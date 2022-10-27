<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class ModuleGenerator extends Generator
{
    /**
     * The directories to be created under the service directory.
     *
     * @var array
     */
    protected array $directories = [
        'Http/',
        'Http/Controllers/',
        'Providers/',
    ];

    /**
     * @throws Exception
     */
    public function generate(string $name): bool
    {
        $name = Str::module($name);
        $slug = Str::snake($name);
        $path = $this->findModulePath($name);

        if (file_exists($path)) {
            return false;
        }
        $this->createDirectory($path);

        $this->createModuleDirectories($path);

        $this->addServiceProviders($name, $slug, $path);

        $this->addDefaultController($name);
        
        $this->createApiRoutes($path);

        return true;
    }

    private function createApiRoutes($path): void
    {
        $content = file_get_contents($this->getRouteStub());

        $this->createFile($path. '/Http/api.php' , $content);
    }

    /**
     * @throws Exception
     */
    public function addServiceProviders($name, $slug, $path): void
    {
        $namespace = $this->findModuleNamespace($name).'\\Providers';

        $this->createRegistrationServiceProvider($name, $path, $slug, $namespace);

        $this->createRouteServiceProvider($name, $path, $namespace);

        $this->createBroadcastServiceProvider($name, $path, $slug, $namespace);
    }

    /**
     * @throws Exception
     */
    public function createRouteServiceProvider(string $name, string $path, string $namespace): void
    {
        $serviceNamespace = $this->findModuleNamespace($name);
        $controllers = $serviceNamespace.'\Http\Controllers';
        $prefix = strtolower($name);

        $content = file_get_contents(__DIR__ . '/stubs/routeserviceprovider.stub');
        $content = str_replace(
            ['{{name}}', '{{namespace}}', '{{controllers_namespace}}', '{{prefix}}'],
            [$name, $namespace, $controllers, $prefix],
            $content
        );

        $this->createFile($path.'/Providers/RouteServiceProvider.php', $content);
    }

    public function createBroadcastServiceProvider($name, $path, $slug, $namespace): void
    {
        $content = file_get_contents(__DIR__ . "/stubs/broadcastserviceprovider.stub");
        $content = str_replace(
            ['{{name}}', '{{slug}}', '{{namespace}}'],
            [$name, $slug, $namespace],
            $content
        );

        $this->createFile($path.'/Providers/BroadcastServiceProvider.php', $content);
    }

    public function createRegistrationServiceProvider($name, $path, $slug, $namespace): void
    {
        $stub = 'serviceprovider.stub';

        $content = file_get_contents(__DIR__ . "/stubs/$stub");
        $content = str_replace(
            ['{{name}}', '{{slug}}', '{{namespace}}'],
            [$name, $slug, $namespace],
            $content
        );

        $this->createFile($path.'/Providers/'.$name.'ServiceProvider.php', $content);
    }

    public function createModuleDirectories($path): void
    {
        foreach ($this->directories as $directory) {
            $this->createDirectory($path.'/'.$directory);
        }
    }

    /**
     * @throws Exception
     */
    public function addDefaultController($module): void
    {
        $name = Str::controller($module);
        $path = $this->findControllerPath($module, $name);
        $namespace = $this->findControllerNamespace($module);
        $content = file_get_contents($this->getControllerStub());
        $content = str_replace(
             ['{{controller}}', '{{namespace}}'],
             [$name, $namespace],
             $content
        );

        $this->createFile($path, $content);
    }

    private function getControllerStub(): string
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    private function getRouteStub(): string 
    {
        return __DIR__ . '/stubs/route-api.stub';
    }
}
