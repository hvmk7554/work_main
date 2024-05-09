<?php

namespace App\Nova;


use App\Nova\Filters\Course\GradeFilter;
use App\Nova\Filters\Course\Stage;
use App\Nova\Filters\Course\SubjectFilter;
use App\Nova\Metrics\Course\AllCourses;
use App\Services\Repository\CourseService;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Course extends Resource
{
    public static $model = \App\Models\Course::class;

    public static $title = 'name';

    public static $with = [
        'grades', 'subjects'
    ];

    //    public static function searchableColumns(): array
    //    {
    //        return ['id', new SearchableText('name'), 'code', 'classin_id'];
    //    }



    public static function applySearch($query, $search)
    {
        return parent::applySearch($query, $search)->orWhere(function ($query) use ($search) {
            $query->search($search, "all");
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Heading::make(null),

            Hidden::make('id'),

            Text::make('ClassIn Course ID', 'classin_id')
                ->hideFromIndex()
                ->rules('nullable', 'alpha_num')
                ->creationRules('unique:courses,classin_id')
                ->updateRules('unique:courses,classin_id,{{resourceId}}'),

            Text::make('Code', 'code')
                ->sortable()
                ->rules('required', 'alpha_dash')
                ->creationRules('unique:courses,code')
                ->updateRules('unique:courses,code,{{resourceId}}')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenUpdating()
                ->default($this->defaultCode()),

            Select::make('Type', 'type')->options(function () {
                return \App\Models\Course::$availableCourseTypes;
            })
                ->displayUsingLabels()->onlyOnIndex(),

            Select::make('Type', 'type')->options(function () {
                return \App\Models\Course::$availableCourseTypes;
            })
                ->default(0)
                ->required()
                ->rules('required')
                ->displayUsingLabels()->hideFromIndex(),

            Text::make('Name on insight', 'name')
                ->sortable()->onlyOnIndex(),

            Text::make('Name on insight', 'name')
                ->sortable()
                ->rules('required')->hideFromIndex(),

            Text::make('Name on website', 'name_on_website')
                ->hideFromIndex()
                ->rules('nullable'),

            Text::make('Name on classin', 'name_on_classin')
                ->hideFromIndex()
                ->rules('nullable'),

            Boolean::make('Active', 'active')
                ->hideFromIndex()
                ->filterable()
                ->default(function () {
                    return false;
                }),

            Boolean::make('Ready for website', 'ready_for_web')
                ->hideFromIndex()
                ->filterable()
                ->default(function () {
                    return false;
                }),

            Number::make('Min students', 'student_min_number')->rules('required')->hideWhenCreating(),

            Date::make('Start Date', 'start_date')->onlyOnIndex(),

            Date::make('End Date', 'end_date')->onlyOnIndex(),

            Select::make('School Year', 'school_year')
                ->options(\App\Models\Course::$availableSchoolYears)
                ->sortable()->onlyOnIndex()->filterable(),

            Select::make('Program', 'program')->rules('required')
                ->options(\App\Models\Program::programAvailable())
                ->displayUsing(function ($v) {
                    return \App\Models\Program::programAvailable()[$v] ?? null;
                })->hideFromIndex()->filterable(),

            Select::make('Program', 'program')->rules('required')
                ->options(\App\Models\Program::programAvailable())
                ->displayUsing(function ($v) {
                    return \App\Models\Program::programAvailable()[$v] ?? null;
                })
                ->sortable()->onlyOnIndex(),
            Text::make('Slug', 'slug')
                ->rules('nullable')
                ->help('This field is auto-generated from the subject, grade, reference book and teacher. You can`t change it.')
                ->hideFromIndex()
                ->exceptOnForms(),
            Image::make('Image', 'image')->hideFromIndex()->nullable()->disableDownload(),

            Image::make('Image (LDB and web 2.0)', 'cover_image')->hideFromIndex()->nullable()->disableDownload(),

            Textarea::make('Introduction', 'introduction')
                ->hideFromIndex()
                ->rules('nullable'),

            Text::make("Max number of classes","class_types_by_subject_config", function() {
                if (!is_string($this->class_types_by_subject_config)) {
                    return "";
                }
                $classTypeString = \App\Models\CourseClass::mapClassType($this->class_types_by_subject_config);

                return $this->max_of_classes_by_subject_config." - ".$classTypeString;
            })->readonly()->hideFromIndex(),

            Date::make('Start Date', 'start_date')
                ->dependsOn(['type'], function (Date $self, NovaRequest $request, FormData $formData) {
                    if ($formData->type == 0) {
                        $self->required()->rules(['required','before_or_equal:end_date']);
                    } else {
                        if (!is_null($request->start_date)) {
                            $self->rules(['before_or_equal:end_date'])->nullable();
                        }
                    }
                })
                ->hideFromIndex(),

            Date::make('End Date', 'end_date')
                ->dependsOn(['type'], function (Date $self, NovaRequest $request, FormData $formData) {
                    if ($formData->type == 0) {
                        $self->required()->rules(['required','after_or_equal:start_date']);
                    } else {
                        if (!is_null($request->end_date)) {
                            $self->rules(['after_or_equal:start_date']);
                        }
                    }
                })
                ->hideFromIndex(),

            Select::make('School Year', 'school_year')
                ->options(\App\Models\Course::$availableSchoolYears)
                ->filterable()
                ->sortable()
                ->rules('nullable')->hideFromIndex()->filterable(),
            Heading::make(null),

            DateTime::make('Created At')
                ->onlyOnDetail(),
            DateTime::make('Updated At')
                ->onlyOnDetail(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [
            AllCourses::make(),
            ];
    }

    public function filters(NovaRequest $request)
    {

        return $this->myFilters();
    }

    protected function myFilters()
    {
        return [
        ];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        $resources = is_array($request->resources) ? count($request->resources) : null;
        return [
            ExportAsCsv::make()->withFormat($this->exportAsCsv())->canRun(function (NovaRequest $request){
                return ($request->user()->in(\App\Models\UserGroup::COURSE_EXPORT) || $request->user()->isAdmin());
            }),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->get('orderBy') == 'stage') {
            return $query->orderBy('end_date', $request->get('orderByDirection'));
        }
        return $query;
    }
    private function defaultCode(): string
    {
        return Str::random(4);
    }

    private function exportAsCsv()
    {
        return function (\App\Models\Course $model) {
            return [
                'ID' => $model->id,
                'Course type' => \App\Models\Course::$availableCourseTypes[$model->type],
                'Code' => $model->code,
                'Slug' => $model->slug,
                'ClassIn ID' => $model->classin_id,
                'Name on Insight' => $model->name,
                'Name on Website' => $model->name_on_website,
                'Name on ClassIn' => $model->name_on_classin,
                'Active' => $model->active,
                'Active student' => $model->getNumberStudentActiveAttribute(),
                'Min student' => $model->student_min_number,
                'School Year' => $model->school_year,
                'Start Date' => $model->start_date ? $model->start_date->toIso8601String() : '-',
                'End Date' => $model->end_date ? $model->end_date->toIso8601String() : '-',
                'Grades' => resolve(CourseService::class)->inlineGrades($model),
                'Subjects' => resolve(CourseService::class)->inlineSubjects($model),
                'Created At' => $model->created_at->toIso8601String(),
                'Updated At' => $model->updated_at->toIso8601String(),
                'Course content ID' => $model->content_id,
                'Program' => $model->program,
            ];
        };
    }

    public function serializeForDetail(NovaRequest $request, Resource $resource)
    {
        $this->handleDelayCourse($resource->resource);

        return parent::serializeForDetail($request, $resource); // TODO: Change the autogenerated stub
    }
}
