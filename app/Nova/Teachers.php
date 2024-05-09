<?php

namespace App\Nova;

use App\Http\Requests\TeacherRequest;
use App\Http\Resources\TeacherResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use FormFeed\DependablePanel\DependablePanel;

use App\Models\Program;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\FormData;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\MultiSelect;
use Bissolli\NovaPhoneField\PhoneNumber;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Filters\Teachers\GenderFilter;
use App\Nova\Filters\Teachers\DegreeFilter;
use App\Nova\HasDependencies;
use App\Nova\NovaDependencyContainer;
use App\Nova\ActionHasDependencies;
use App\Nova\Filters\Teacher;
use Epartment\NovaDependencyContainer\NovaDependencyContainer as NovaDependencyContainerNovaDependencyContainer;

use Illuminate\Support\Facades\Hash;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasManyThrough;

class Teachers extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Teachers>
     */
    public static $model = \App\Models\Teachers::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'email',
        'phone'
    ];

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

            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:32')
                ->placeholder("Enter name here..."),

            Date::make('Birthday', 'DOB')
                ->rules('required', 'before:today')
                ->sortable()
                ->displayUsing(fn ($value) => $value ? $value->format('d/m/Y') : ''),
            // format : 'D d/m/Y, g:ia'

            Text::make('Email', 'email')
                ->rules('required', 'email', 'max:254')
                ->placeholder("Enter email here..."),
            // PhoneNumber::make('Phone number')->withCustomFormats('+84 ## ### ####'),
            Text::make('Phone', 'phone')->required()->placeholder("Enter phone number here..."),

            Select::make('Gender')->options(function () {
                return \App\Models\Teachers::$gender;
            })->required()->displayUsingLabels(),

            Select::make('Contact type')->options(function () {
                return \App\Models\Teachers::$contact;
            })->displayUsingLabels(),

            Select::make('Degree')->options(function () {
                return \App\Models\Teachers::$degree;
            })->displayUsingLabels(),
            // MultiSelect::make('Degree')->options(function () {
            //     return \App\Models\TeachersM::$degree;
            // })
            // ->displayUsingLabels(),

            Text::make('Address', 'address')->placeholder("Enter address here..."),
            Text::make('Workplace', 'workplace')->placeholder("Enter workplace here..."),

            
    

            // Select::make('grade', 'grade_id')
            //   ->dependsOn(['program'],
            //     function (Select $field, NovaRequest $request, FormData $formData) {
            //         $program= \App\Models\Program::query()
            //        ->where('name',$formData->program)
            //         ->value('id');
                   
            //         $pg= \App\Models\Program::query()
            //       ->find($program);
   
            //     if (!empty($program)){
            //        $field->options(
            //         $pg
            //         ->grades()->get()
            //         ->pluck('name','id')->toArray());    }        
            // })
            // ->displayUsing(function ($grade_id){
            //     return Grade::query()
            //     ->find($grade_id)?
            //     ->name ?? ;
            // })
            // ,  
    
// HasMany::make('Grades','grades',Grade::class),

// HasManyThrough::make('Grades')
// ->syncDependsOn(
//     'program_grade'
// )
// ,

// DependablePanel::make('grade panel', [
//     Select::make('program')->options([
//         1 => 'MOET',
//         2 => 'IELTS',
//         3 => 'Gia sư',
//         4 => 'Toán tư duy',
//         5 => 'Coding',
//         6 => 'Cambridge',
//         8 => 'Elizi',
//         7 => 'Khác',
//         9 => 'FOLA',
//     ]),
    
//     Select::make('grade')
//         ->dependsOn(["program"], function (Select $field, NovaRequest $request, FormData $formData) {
//             if ($formData['program'] == "1") {
//                 $field->options([
//                     1 => 'Lớp 1',
//                     2 => 'Lớp 2',
//                     3 => 'Lớp 3',
//                     4 => 'Lớp 4',
//                     5 => 'Lớp 5',
//                     6 => 'Lớp 6',
//                     7 => 'Lớp 7',
//                     8 => 'Lớp 8',
//                     9 => 'Lớp 9',
//                     10 => 'Lớp 10',
//                     11 => 'Lớp 11',
//                     12 => 'Lớp 12',
//                 ]);
//             }

//             if ($formData['program'] == "9") {
//                 $field->options([
//          13 => 'Ielts 0.5-1.5',
//         14 => 'Ielts 1.5-4.5',
//         15 => 'Ielts 4.5-6.5',
//         16 => 'Ielts 6.5-7.5',
//                 ]);
//             }
//         }), 
    
// ])
// ->singleRequest(true),

    Select::make('program')->options([
        1 => 'MOET',
        2 => 'IELTS',
        3 => 'Gia sư',
        4 => 'Toán tư duy',
        5 => 'Coding',
        6 => 'Cambridge',
        8 => 'Elizi',
        7 => 'Khác',
        9 => 'FOLA',
    ]),

    Select::make('grade')
    
    ->dependsOn(
        ['program'],
        function (Select $field, NovaRequest $request, FormData $formData) {
            if ($formData->program === '1') {
                $field->options([
                                        1 => 'Lớp 1',
                                        2 => 'Lớp 2',
                                        3 => 'Lớp 3',
                                        4 => 'Lớp 4',
                                        5 => 'Lớp 5',
                                        6 => 'Lớp 6',
                                        7 => 'Lớp 7',
                                        8 => 'Lớp 8',
                                        9 => 'Lớp 9',
                                        10 => 'Lớp 10',
                                        11 => 'Lớp 11',
                                        12 => 'Lớp 12',
                                    ]);
            }

            if ($formData->program === '9') {
                $field->options([
                    13 => 'Ielts 0.5-1.5',
                            14 => 'Ielts 1.5-4.5',
                            15 => 'Ielts 4.5-6.5',
                            16 => 'Ielts 6.5-7.5',
                                    ]);
            }
        }
    ),

URL::make('photo_link'),

Select::make('area')->options(function () {
    return \App\Models\Teachers::$area;
})->displayUsingLabels(),
          


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
        return $this->myFilters();
    }
    protected function myFilters()
    {
        return [
            GenderFilter::make(),
            DegreeFilter::make(),
        ];
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
