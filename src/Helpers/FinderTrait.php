<?php

namespace MagedAhmad\Insular\Helpers;

use Exception;
use JsonException;
use JetBrains\PhpStorm\Pure;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

trait FinderTrait
{
    /**
     * @throws Exception
     */
    public function findModuleNamespace($module = null): string
    {
        return "Modules\\$module";
    }

    public function findInsularRootPath(): string
    {
        return base_path() . DS .'Modules';
    }

    public function findModulePath(string $module): string
    {
        return $this->findInsularRootPath(). DS . $module;
    }

    public function findOperationsRootPath(string $module): string
    {
        return $this->findModulePath($module). DS . 'Operations';
    }

    public function findOperationPath(string $module, string $operation): string
    {
        return $this->findOperationsRootPath($module). DS . "$operation.php";
    }

    /**
     * @throws Exception
     */
    public function findOperationNamespace($module): string
    {
        return $this->findModuleNamespace($module).'\\Operations';
    }

    public function findJobsRootPath(string $module): string
    {
        return $this->findModulePath($module). DS . 'Jobs';
    }

    public function findJobPath(string $module, string $job): string
    {
        return $this->findJobsRootPath($module). DS . "$job.php";
    }

    /**
     * @throws Exception
     */
    public function findJobNamespace(string $module): string
    {
        return $this->findModuleNamespace($module).'\\Jobs';
    }

    public function findExceptionPath(string $module, string $exception): string
    {
        return $this->findExceptionsRootPath($module). DS . "$exception.php";
    }

    public function findExceptionsRootPath(string $module): string
    {
        return $this->findModulePath($module). DS . 'Exceptions';
    }

    /**
     * @throws Exception
     */
    public function findExceptionNamespace(string $module): string
    {
        return $this->findModuleNamespace($module).'\\Exceptions';
    }

    public function findFeaturesRootPath(string $module): string
    {
        return $this->findModulePath($module). DS . 'Features';
    }

    public function findFeaturePath(string $module, string $feature): string
    {
        return $this->findFeaturesRootPath($module). DS . "$feature.php";
    }

    /**
     * @throws Exception
     */
    public function findFeatureNamespace($module): string
    {
        return $this->findModuleNamespace($module).'\\Features';
    }

    public function findControllerPath($service, $controller): string
    {
        return $this->findModulePath($service).DS.join(DS, ['Http', 'Controllers', "$controller.php"]);
    }

    /**
     * @throws Exception
     */
    public function findControllerNamespace($module): string
    {
        return $this->findModuleNamespace($module).'\\Http\\Controllers';
    }

    public function findMigrationPath($module, $migration): string
    {
        return $this->findModulePath($module).DS.join(DS, ['database', 'migrations', date("Y_m_d_h_i") . "_$migration.php"]);
    }

    #[Pure]
    protected function relativeFromReal($path, $needle = ''): string
    {
        if (!$needle) {
            $needle = $this->getSourceDirectoryName().DS;
        }

        return strstr($path, $needle);
    }

    public function findModelPath($module, $model): string
    {
        return $this->findModulePath($module). DS . 'Models' . DS . "$model.php";
    }

    /**
     * @throws Exception
     */
    public function findModelNamespace($module): string
    {
        return $this->findModuleNamespace($module).'\\Models';
    }

    public function findTypePath($module, $type): string
    {
        return $this->findModulePath($module) . DS . 'Types' . DS . "$type.php";
    }

    /**
     * @throws Exception
     */
    public function findTypeNamespace($module): string
    {
        return $this->findModuleNamespace($module).'\\Types';
    }

    public function findResourcePath($module, $resource): string
    {
        return $this->findModulePath($module) . DS . 'Http' . DS . 'Resources' . DS . "$resource.php";
    }

    /**
     * @throws Exception
     */
    public function findResourceNamespace($module): string
    {
        return $this->findModuleNamespace($module).'\\Http\\Resources';
    }

    public function findRequestPath($module, $request): string
    {
        return $this->findModulePath($module) . DS . 'Http'  . DS . 'Requests' . DS . "$request.php";
    }

    /**
     * @throws Exception
     */
    public function findRequestNamespace($module): string
    {
        return $this->findModuleNamespace($module).'\\Http\\Requests';
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function findNamespace(string $dir): string
    {
        // read composer.json file contents to determine the namespace
        $composer = json_decode(file_get_contents(base_path() . DS . 'composer.json'), true, 512, JSON_THROW_ON_ERROR);

        // see which one refers to the "src/" directory
        foreach ($composer['autoload']['psr-4'] as $namespace => $directory) {
            $directory = str_replace(['/', '\\'], DS, $directory);
            if ($directory === $dir.DS) {
                return trim($namespace, '\\');
            }
        }

        throw new \RuntimeException('App namespace not set in composer.json');
    }

    public function findFeaturesTestRootPath(string $module): string
    {
        return base_path(). DS . 'tests' . DS  . $module . DS . 'Features';
    }

    public function findFeatureTestNamespace(string $module): string
    {
        return $this->findFeaturesTestRootPath($module);
    }

    public function findFeatureTestPath($module, $test): string
    {
        $root = $this->findFeaturesTestRootPath($module);

        return join(DS, [$root, "$test.php"]);
    }

    public function findJobsTestRootPath(string $module): string
    {
        return base_path(). DS . 'tests' . DS  . $module . DS . 'Jobs';
    }

    public function findJobTestNamespace(string $module): string
    {
        return $this->findJobsTestRootPath($module);
    }

    public function findJobTestPath($module, $test): string
    {
        $root = $this->findJobsTestRootPath($module);

        return join(DS, [$root, "$test.php"]);
    }

    public function findOperationsTestRootPath(string $module): string
    {
        return base_path(). DS . 'tests' . DS  . $module . DS . 'Operations';
    }

    public function findOperationTestNamespace(string $module): string
    {
        return $this->findOperationsTestRootPath($module);
    }

    public function findOperationTestPath($module, $test): string
    {
        $root = $this->findOperationsTestRootPath($module);

        return join(DS, [$root, "$test.php"]);
    }
}
