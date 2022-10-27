<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class ResourceGenerator extends Generator
{
    /**
     * @throws Exception
     */
    public function generate(string $name, string $module): bool
    {
        $name = Str::resource($name);
        $module = Str::module($module);

        $path = $this->findResourcePath($module, $name);

        if (file_exists($path)) {
            return false;
        }

        $namespace = $this->findResourceNamespace($module);

        $content = file_get_contents($this->getStub());
        $content = str_replace(
             ['{{resource}}', '{{namespace}}'],
             [$name, $namespace],
             $content
         );

        $this->createFile($path, $content);

        return true;
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/resource.stub';
    }
}
