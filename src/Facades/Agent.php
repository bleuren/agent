<?php

declare(strict_types=1);

namespace Bleuren\Agent\Facades;

use Illuminate\Support\Facades\Facade;

class Agent extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'agent';
    }

    public static function __callStatic($method, $parameters)
    {
        return app('agent')->$method(...$parameters);
    }
}
