<?php

declare(strict_types=1);

namespace Bleuren\Agent;

use Illuminate\Support\ServiceProvider;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class AgentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('agent', function ($app) {
            return new Agent(new CustomMobileDetect, new CrawlerDetect);
        });

        $this->app->alias('agent', Agent::class);
    }

    public function provides()
    {
        return [Agent::class];
    }
}
