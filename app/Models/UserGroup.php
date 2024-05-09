<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    public const ADMINISTRATOR = 1;
    public const COURSE_READ = 2;
    public const COURSE_WRITE = 3;
    public const COURSE_DESTROY = 4;
    public const SKU_READ = 5;
    public const SKU_WRITE = 6;
    public const SKU_DESTROY = 7;
    public const TEACHER_READ = 8;
    public const TEACHER_WRITE = 9;
    public const TEACHER_DESTROY = 10;
    public const CURRICULUM_READ = 11;
    public const CURRICULUM_WRITE = 12;
    public const CURRICULUM_DESTROY = 13;
    public const COURSE_CLASS_READ = 14;
    public const COURSE_CLASS_WRITE = 15;
    public const COURSE_CLASS_DESTROY = 16;
    public const SUBSCRIPTION_READ = 17;
    public const SUBSCRIPTION_WRITE = 18;
    public const SUBSCRIPTION_DESTROY = 19;
    public const SUBSCRIPTION_EXPORT = 29;
    public const ZALOSENDZNS_READ = 20;
    public const ZALOSENDZNS_WRITE = 21;
    public const ZALOSENDZNS_DESTROY = 22;
    public const ZALOTEMPLATE_READ = 23;
    public const ZALOTEMPLATE_WRITE = 24;
    public const ZALOTEMPLATE_DESTROY = 25;
    public const COURSE_CONTENT_READ = 26;
    public const COURSE_CONTENT_WRITE = 27;
    public const COURSE_CONTENT_DESTROY = 28;
    public const STUDENT_READ_ONLY_ME = 30;
    public const STUDENT_WRITE_ONLY_ME = 31;
    public const STUDENT_DELETE = 32;
    public const STUDENT_EXPORT = 33;
    public const AREA_READ = 34;
    public const AREA_WRITE = 35;
    public const AREA_DESTROY = 36;
    public const AREA_EXPORT = 37;
    public const DEPARTMENT_READ = 38;
    public const DEPARTMENT_WRITE = 39;
    public const DEPARTMENT_DESTROY = 40;
    public const DEPARTMENT_EXPORT = 41;
    public const TEAM_READ = 42;
    public const TEAM_WRITE = 43;
    public const TEAM_DESTROY = 44;
    public const TEAM_EXPORT = 45;
    public const COURSE_EXPORT = 46;
    public const SKU_EXPORT = 47;
    public const COURSE_CLASS_EXPORT = 48;
    public const CURRICULUM_EXPORT = 49;
    public const PROMOTION_REDEEM_HISTORY = 50;
    public const ACTION_EVENT_EXPORT = 51;
    public const STUDENT_WRITE_ALL = 52;
    public const STUDENT_READ_ALL = 53;

    public const PROMOTION_WRITE = 54;
    public const PROMOTION_READ = 55;
    public const PROMOTION_DELETE = 56;
    public const STUDENT_RESET_CLASS_IN_PASSWORD = 57;
    public const SUBSCRIPTION_ASSIGN_RENEWAL_OWNER = 58;

    public const STUDENT_TAGS_CREATE_UPDATE=59;

    public const STUDENT_TAGS_DELETE=60;

    public const STUDENT_TAGS_READ=61;

    public const EXAM_ATTEMPT_VIEW = 62;
    public const EXAM_ATTEMPT_EDIT = 63;
    public const EXAM_ATTEMPT_DELETE = 64;
    public const TEACHER_ASSESSMENT_READ = 65;
    public const TEACHER_ASSESSMENT_GENERATE_AND_UPDATE = 66;
    public const TEACHER_ASSESSMENT_DELETE = 67;
    public const TEACHER_ASSESSMENT_EXPORT_AND_IMPORT = 68;

    public const EXAM_EXPORT = 69;

    public function userGroupMemberships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserGroupMembership::class);
    }
}
