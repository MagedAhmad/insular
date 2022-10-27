<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class RequestGenerator extends Generator
{
    /**
     * @throws Exception
     */
    public function generate(string $name, string $module): bool
    {
        $name = Str::request($name);
        $module = Str::module($module);

        $path = $this->findRequestPath($module, $name);

        if (file_exists($path)) {
            return false;
        }

        $namespace = $this->findRequestNamespace($module);

        $content = file_get_contents($this->getStub());
        $content = str_replace(
             ['{{request}}', '{{namespace}}'],
             [$name, $namespace],
             $content
         );

        $this->createFile($path, $content);

        return true;
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/request.stub';
    }
}
