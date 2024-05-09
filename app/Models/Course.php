<?php

namespace App\Models;

use App\Helpers\ArrayUtils;
use App\Helpers\StringUtils;
use App\Helpers\Utils;
use App\Traits\ActionEventCustomTrait;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Actionable;


/**
 * @property Date $start_date
 * @property Date $end_date
 * @property Date $start_date_old
 * @property Date $end_date_old
 * @property CrossSell|Collection|null $crossSell
 * @property Sku|Collection|null $skus
 */
class Course extends Model
{

    protected $table='courses';

    use Actionable, HasFactory, SoftDeletes, ActionEventCustomTrait;

    const COURSE_TYPE_CLASS_MASS = 0;
    const COURSE_TYPE_CLASS_TUTOR = 5; // 1 - n
    const COURSE_TYPE_CLASS_TUTOR_1_1 = 9; // 1 - 1

    //
    public const COURSE_EXPIRED = 'course_expired';
    public const COURSE_CANCELLED = 'course_cancelled';
    public const COURSE_RESERVE = 'course_reserve';
    public static array $courseCancellationReason = [
        'course_expired' => 'Course expired',
        'course_cancelled' => 'Course cancelled',
        'course_reserve' => 'Reserve',
        'course_transfer' => 'Course transfer'
    ];

    public static array $availableSchoolYears = [
        '2021 - 2022' => '2021 - 2022',
        '2022 - 2023' => '2022 - 2023',
        '2023 - 2024' => '2023 - 2024',
        '2024 - 2025' => '2024 - 2025',
        "001" => "001",
        "002" => "002",
        "003" => "003",
        "004" => "004",
        "005" => "005",
        "006" => "006",
        "007" => "007",
        "008" => "008",
        "009" => "009",
        "010" => "010",
        "011" => "011",
        "012" => "012",
        "013" => "013",
        "014" => "014",
        "015" => "015",
        "016" => "016",
        "017" => "017",
        "018" => "018",
        "019" => "019",
        "020" => "020",
        "021" => "021",
        "022" => "022",
        "023" => "023",
        "024" => "024",
        "025" => "025",
        "026" => "026",
        "027" => "027",
        "028" => "028",
        "029" => "029",
        "030" => "030"
    ];

    public static array $availableGroupingType = [
        'month' => 'Month',
        'week' => 'Week'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_date_old' => 'date',
        'end_date_old' => 'date',
        'ready_for_web' => 'boolean',
        'classin_allow_add_friend' => 'boolean',
        'student_min_number' => 'integer'
    ];

    protected $fillable = ['slug', 'ready_for_web', 'content_id', 'classin_id', 'active','max_of_classes_by_subject_config','class_types_by_subject_config'];

//    protected $with = ['curriculum', 'teachers','students'];

    public static $area = [
        1 => "Miền Bắc",
        2 => "Miền Nam",
        3 => "Miền Trung",
        4 => "Vietnam",
        5 => "Western",
        6 => "Philippine"
    ];
    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class, 'course_grades')
            ->using(CourseGrade::class)
            ->orderByDesc('grade_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'course_subjects')
            ->using(CourseSubject::class);
    }
    public function getPrograms(): HasOne
    {
        return $this->hasOne(Program::class,"name","program");
    }

    public static array $availableProgram = [
        'moet' => 'MOET',
        'ielts' => 'IELTS',
//        'tutoring' => 'Gia sư',
        'toan_tu_duy' => 'Toán tư duy',
        'programming' => 'Coding',
        'cambridge' => 'Cambridge',
        'elizi' => 'Elizi',
        'toeic' => 'TOEIC',
        'sym' => 'SYM',
        'other' => 'Khác'
    ];

    public static array $availableCourseTypes = [
        0 => 'Lớp Mass',
        1 => 'Khoá học trải nghiệm EC',
        2 => 'Khai giảng',
        3 => 'Phụ đạo',
        4 => 'Chuyên đề',
        6 => 'Paid in advance',
        7 => 'Infinity',
        8 => 'Interaction',
        5 => 'Gia sư 1:n',
        9 => 'Gia sư 1:1'
    ];

    /**
     * @param Builder $query
     * @param $search
     * @param string $match: all || one
     * @return void
     */
    public function scopeSearch(Builder $query, string $search, string $match = "all"): void {

        $dbInsight=  config('app.env') == 'production' ? 'insight' : 'laravel';
        $search = trim(Utils::removeSpecialChar($search), " ");
        $splitSearch = explode(" ", $search);
        $searchValueArr = [];
        $prefix = "";
        if ($match == "all") {
            $prefix = "+";
        }
        foreach ($splitSearch as $val) {
            if (empty($val)) {
                continue;
            }
            $searchValueArr[] = $prefix . $val;
        }
        $searchValue = implode(" ", $searchValueArr);
        $query->whereRaw("MATCH (".$dbInsight.".courses.name) AGAINST (? IN BOOLEAN MODE) OR ".$dbInsight.".courses.id like ? OR ".$dbInsight.".courses.code like ? or ".$dbInsight.".courses.classin_id like ?",
            [$searchValue, $search, $search, $search]);

    }
}
