<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class ModelGenerator extends Generator
{
    /**
     * @throws Exception
     */
    public function generate(string $name, string $module): bool
    {
        $name = Str::model($name);
        $module = Str::module($module);

        $path = $this->findModelPath($module, $name);

        if (file_exists($path)) {
            return false;
        }

        $namespace = $this->findModelNamespace($module);

        $content = file_get_contents($this->getStub());
        $content = str_replace(
             ['{{model}}', '{{namespace}}'],
             [$name, $namespace],
             $content
         );

        $this->createFile($path, $content);

        return true;
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/model.stub';
    }
}
