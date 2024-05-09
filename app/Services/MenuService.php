<?php

namespace App\Services;

use App\Nova\Subscription;
use App\Nova\Student;
use App\Nova\Sku;
use App\Nova\Course;
use App\Nova\Dashboards\Main;
use App\Nova\Grade;
use App\Nova\Program;
use App\Nova\Subject;
use App\Nova\Teachers;
use App\Nova\Classes;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;

class MenuService
{
    public static function getMenus(Request $req): array
    {
        return [
            MenuSection::dashboard(Main::class),
            MenuSection::make("Learning managements", [
                MenuItem::resource(Sku::class),
                MenuItem::resource(Student::class),
                MenuItem::resource(Course::class),
                MenuItem::resource(Subject::class),
                MenuItem::resource(Grade::class),
                MenuItem::resource(Program::class),
                MenuItem::resource(Teachers::class),
                MenuItem::resource(Classes::class),
                MenuItem::resource(Subscription::class),
            ])
        ];
    }

    public static function getMenusJson(Request $req): array
    {
        $menus = self::getMenus($req);
        $menuJson = [];
        foreach ($menus as $menu) {
            $menuJson[] = $menu->jsonSerialize();
        }

        return $menuJson;
    }
}
