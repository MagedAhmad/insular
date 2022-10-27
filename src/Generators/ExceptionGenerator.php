<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class ExceptionGenerator extends Generator
{
    /**
     * @throws Exception
     */
    public function generate(string $exception, string $module): bool
    {
        $module = Str::module($module);

        $path = $this->findExceptionPath($module, $exception);

        if (file_exists($path)) {
            return false;
        }

        $namespace = $this->findExceptionNamespace($module);

        $content = file_get_contents(__DIR__ . "/stubs/exception.stub");

        $content = str_replace(
            ['{{exception}}', '{{namespace}}'],
            [$exception, $namespace],
            $content
        );

        $this->createFile($path, $content);

        return true;
    }
}
