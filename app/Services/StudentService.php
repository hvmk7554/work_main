<?php

namespace App\Services;

use App\Models\UserDbUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentService
{
    private static ?StudentService $instance = null;
    private array $studentAttempts;

    public function __construct()
    {
        $this->studentAttempts = [];
    }

    public function examAttempts($studentId): array|null
    {
        if (isset($this->studentAttempts[$studentId]) && $this->studentAttempts[$studentId] != null) {
            return $this->studentAttempts[$studentId];
        }

        Log::info('step 1', [
            'user' => $studentId,
        ]);

        $user = UserDbUser::query()->where('insight_id', '=', $studentId)->first();
        if ($user == null) {
            return null;
        }

        $attempts = $this->getExamAttemptsOfStudent($user->id);

        $weights = $this->getWeightConfig();

        $courses = $this->getCourseOfStudent($studentId);

        $evaluations = $this->getEvaluations();

        Log::info('step 2', [
            'user' => $user->id,
            'attempts' => $attempts,
            'weight' => $weights,
            'courses' => $courses,
            'evaluations' => $evaluations,
        ]);

        $scores = [];
        $log = [
            'debugs' => []
        ];

        foreach ($attempts as $attempt) {
            // Course not exist
            if (!isset($courses[$attempt->course_id]))
            {
                continue;
            }
            $cfg = $courses[$attempt->course_id];
            $program = $cfg['program'];
            $curriculum = $cfg['curriculum'];
            // Program do not have config
            if (!isset($weights[$program]))
            {
                continue;
            }

            if (!isset($evaluations[$program]))
            {
                continue;
            }
            $evaluation = $evaluations[$program];

            if (!isset($attempt->variant_id))
            {
                continue;
            }

            $weightCfg = $weights[$program];
            $weight = $weightCfg[$attempt->variant_id] ?? 0;

            if (!isset($scores[$curriculum]))
            {
                $scores[$cfg['curriculum']] = [
                    'p' => $program,
                    'e' => $evaluation,
                    'v' => 0,
                    'n' => 0
                ];
            }
            $s=0;
            if($attempt->max_score!=0){
                $s = $attempt->score * (100 / $attempt->max_score);
            }
            $log[$attempt->id] = [
                'middleScore' => $s,
                'weight' => $weight
            ];
            if($weight!=0 && $s!=0){
                $scores[$curriculum]['v'] += $weight * $s;
            }
            $scores[$curriculum]['n'] += $weight;
        }

        Log::info('step 3', [
            'score' => $scores,
            'logs' => $log,
        ]);
        $finalScore = [];
        foreach ($scores as $c => $v)
        {
            $evaluation = $v['e'];
            $fc=0;
            if($v['v']!=0 && $v['n']!=0){
                $fc =  $v['v'] / $v['n'];
            }
            $ev = '';
            foreach ($evaluation['level'] as $level)
            {
                if ($ev == '')
                {
                    $ev = $level['v'];
                }
                if ($fc < $level['k'])
                {
                    break;
                }
                $ev = $level['v'];
            }

            $finalScore[$c] = [
                'score' => $fc,
                'comment' => $ev
            ];
        }

        $this->studentAttempts[$studentId] = $finalScore;

        return $this->studentAttempts[$studentId];
    }

    private function getWeightConfig(): array
    {
        $program = [];
        $configs = DB::connection('mysql_exam')->table('exam_weight_configs')->get()->toArray();
        foreach ($configs as $cfg)
        {
            if (!isset($program[$cfg->program_id])) {
                $program[$cfg->program_id] = [];
            }
            $program[$cfg->program_id][$cfg->variant_id] = $cfg->weight;
        }

        return $program;
    }

    private function getExamAttemptsOfStudent($user): array {
        return DB::connection('mysql_exam')->table('exam_attempts as ea')->join('exams as e', 'ea.exam_id', '=', 'e.id')
            ->select(
                'ea.id as id',
                'ea.total_score as score',
                'ea.course_id as course_id',

                'e.id as exam_id',
                'e.score as max_score',
                'e.exam_variant_id as variant_id'
            )
            ->where('ea.user_id', '=', $user)
            ->where('ea.course_id', '>', 0)
            ->whereRaw('ea.total_score IS NOT NULL')
            ->get()->toArray();
    }

    private function getCourseOfStudent($studentId): array
    {
        $courses = DB::table('hs_assignments as ha')
            ->join('subscriptions as s', 'ha.classin_uid', '=', 's.classin_uid')
            ->join('courses as c', 's.course_id', '=', 'c.classin_id')
            ->join('programs as p', 'c.program', '=', 'p.name')
            ->join('curricula as c2', 'c.curriculum_id', '=', 'c2.id')
            ->where('ha.id', '=', $studentId)
            ->groupBy('c.id')
            ->select('c.id as course', DB::raw('max(c2.id) as curriculum'), DB::raw('max(p.id) as program'))
            ->get()->toArray();

        $result = [];
        foreach ($courses as $course)
        {
            $result[$course->course] = [
                'program' => $course->program,
                'curriculum' => $course->curriculum,
            ];
        }

        return $result;
    }

    private function getEvaluations(): array {
        $evaluations = DB::table('evaluations')
            ->select(DB::raw('evaluations.*'), 'level_of_evaluations.exam_variant_ids as variants', 'level_of_evaluations.program_id as program')
            ->leftJoin('level_of_evaluations', 'evaluations.level_of_evaluation_id', '=', 'level_of_evaluations.id')
            ->where('level_of_evaluations.level', '=', 1)
            ->orderBy('evaluations.evaluation_value')
            ->get()->toArray();

        Log::info('step 2.1', [
            'evaluations' => $evaluations
        ]);

        $result = [];
        foreach ($evaluations as $e)
        {
            $p = $e->program;
            if (!isset($result[$p])) {
                $result["{$p}"] = [
                    'level' => [],
                    'variants' => []
                ];
            }
            $variants = json_decode($e->variants);
            $result[$p]['level'][] = [
                'k' => $e->evaluation_value,
                'v' => $e->evaluation_comment,
            ];

            foreach ($variants as $v)
            {
                $result[$p]['variants'][$v] = 1;
            }
        }

        return $result;
    }

    public static function getInstance(): ?StudentService
    {
        if (self::$instance == null) {
            self::$instance = new StudentService();
        }

        return self::$instance;
    }
}
