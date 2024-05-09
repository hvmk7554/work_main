<?php

namespace App\Nova;

use App\Models\Program as ProgramModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\MultiselectField\Multiselect;

class SubjectConfig extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\SubjectConfig>
     */
    public static $model = \App\Models\SubjectConfig::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function createButtonLabel()
    {
        return "Create max number of classes";
    }
    public static function label()
    {
        return "Max number of classes";
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Select::make("Grade", "grade_id")->options(function () use($request){
                $subjectId = $request->get("viaResourceId") ?? $this->resource->subject_id;
                $subject = \App\Models\Subject::query()->find($subjectId);

                $availableGrades = \App\Models\SubjectConfig::query()->where("subject_id", $subject->id)->where("grade_id","!=",$this->resource?->grade_id)->pluck("grade_id")->toArray();

                return \App\Models\Grade::query()->join("program_grades","program_grades.grade_id","grades.id")
                                                 ->join("programs","program_grades.program_id","programs.id")
                                                 ->where("programs.id", $subject?->program_id)
                                                 ->whereNotIn("grades.id", $availableGrades)
                                                 ->orderBy("grades.id")->pluck("grades.name","grades.id")->toArray();
            })->displayUsingLabels()->required()->rules("required"),

            Multiselect::make('Class types','class_types')->options(function () use($request){
                return \App\Models\CourseClass::$availableClassTypes;
            })->asHtml()->hideFromIndex()->required()->rules("required"),

            Text::make('Class types',function () {
                $class_types = json_decode($this->class_types);
                $list = [];
                if (!empty($class_types))
                {
                    foreach ($class_types as $data)
                    {
                        $list[] = \App\Models\CourseClass::$availableClassTypes[$data] ?? null;
                    }
                }
                return view('partials.teacherAssessment.base-lines', [
                    'data' => $list
                ])->render();
            })->onlyOnIndex()->asHtml(),

            Number::make("Number", "number_of_class")->rules("required")->min(1)
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
