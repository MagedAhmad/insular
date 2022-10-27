<?php

namespace MagedAhmad\Insular\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseServiceProvider;

abstract class RouteServiceProvider extends BaseServiceProvider
{
    abstract public function map(Router $router);

    public function loadRoutesFiles($router, $namespace, $routes = null, $prefix = ''): void
    {
        if (is_file($routes)) {
            $this->mapApiRoutes($router, $namespace, $routes, prefix: $prefix);
        }
    }

    protected function mapApiRoutes($router, $namespace, $path, string $prefix=''): void
    {
        $router->group([
            'middleware' => 'api',
            'namespace'  => $namespace,
            'prefix'     => $prefix // to allow the delete or change of api prefix
        ], function ($router) use ($path) {
            require $path;
        });
    }

    protected function mapWebRoutes($router, $namespace, $path): void
    {
        $router->group([
            'middleware' => 'web',
            'namespace'  => $namespace
        ], function ($router) use ($path) {
            require $path;
        });
    }
}
