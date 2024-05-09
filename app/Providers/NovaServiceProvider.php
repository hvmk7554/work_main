<?php

namespace App\Providers;

use App\Models\User;
use App\Nova\Dashboards\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Mrt\StudentPerformanceChart\StudentPerformanceChart;
use Stepanenko3\LogsTool\LogsTool;
use Mrt\BookingForm\BookingForm;
use App\Services\MenuService;
class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot()
    {

        parent::boot();
        $this->registerFooter();
        $this->registerMenu();
        $this->registerStyle();
    }

    private function registerFooter()
    {
        Nova::footer(function () {
            return Blade::render('
                <p class="text-center">Powered by <a class="link-default" href="https://nova.laravel.com">Laravel Nova</a> · v{!! $version !!}</p>
                <p class="text-center">&copy; {!! $year !!} <a class="link-default" href="https://marathon.edu.vn"> Marathon Education</a></p>
            ', [
                'version' => Nova::version(),
                'year' => date('Y'),
            ]);
        });
    }

    private function registerMenu()
    {
        Nova::mainMenu(function (Request $request) {
            return MenuService::getMenus($request);
        });
    }

    private function registerStyle()
    {
        Nova::style('admin', asset('css/nova.css'));
        Nova::style('custom', resource_path('css/nova_custom.css'));
    }

    public function tools()
    {
        return [
        ];
    }

    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->register();
    }

    public function register()
    {
        //
    }

    protected function gate()
    {
        Gate::define('viewNova', function (User $user) {
            return $user->authority_level > -1000;
        });
    }

    protected function dashboards()
    {
        return [
            new Main,
        ];
    }
}
