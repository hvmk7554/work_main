<?php

namespace App\Providers;

use App\Models\CourseStudent;
use App\Models\StudentCourseRecord;
use App\Models\Subscription;
use App\Models\UserDbUser;
use App\Nova\UserTeacherCenter;
use App\Policies\StudentCourseAddedPolicy;
use App\Policies\StudentCourseRecordPolicy;
use App\Policies\UserTeachCenterPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        CourseStudent::class  => StudentCourseAddedPolicy::class,
        StudentCourseRecord::class => StudentCourseRecordPolicy::class,
        UserDbUser::class => UserTeachCenterPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
