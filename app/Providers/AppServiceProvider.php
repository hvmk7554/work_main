<?php

namespace App\Providers;

use App\Services\External\MarathonIntegrationService;
use App\Services\NotificationService;
use App\Services\RedisPublishingService;
use App\Services\Repository\SkuService;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerServices();

        if (Str::startsWith(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        if (Env::get('APP_ENV') == 'local') {
            DB::listen(function (QueryExecuted $q) {
                Log::debug('Query', [
                    'q' => $q->sql,
                    'b' => $q->bindings,
                    't' => $q->time
                ]);
            });
        }
    }

    private function registerServices()
    {
        $this->app->singleton(MarathonIntegrationService::class);
        $this->app->singleton(SkuService::class);
        $this->app->singleton(NotificationService::class);
        $this->app->singleton(RedisPublishingService::class);
    }
}
