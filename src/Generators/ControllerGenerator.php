<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class ControllerGenerator extends Generator
{
    /**
     * @throws Exception
     */
    public function generate(string $name, string $module): bool
    {
        $name = Str::controller($name);
        $module = Str::module($module);

        $path = $this->findControllerPath($module, $name);

        if (file_exists($path)) {
            return false;
        }

        $namespace = $this->findControllerNamespace($module);

        $content = file_get_contents($this->getStub());
        $content = str_replace(
             ['{{controller}}', '{{namespace}}'],
             [$name, $namespace],
             $content
         );

        $this->createFile($path, $content);

        return true;
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/controller.stub';
    }
}
