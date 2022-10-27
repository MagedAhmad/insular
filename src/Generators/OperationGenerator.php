<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class OperationGenerator extends Generator
{
    /**
     * @throws Exception
     */
    public function generate(string $operation, string $module): bool
    {
        $operation = Str::operation($operation);
        $module = Str::module($module);

        $path = $this->findOperationPath($module, $operation);

        if (file_exists($path)) {
            return false;
        }

        $namespace = $this->findOperationNamespace($module);

        $content = file_get_contents(__DIR__ . "/stubs/operation.stub");

        $content = str_replace(
            ['{{operation}}', '{{namespace}}'],
            [$operation, $namespace],
            $content
        );

        $this->createFile($path, $content);

        $this->generateTestFile($operation, $module);

        return true;
    }

    private function generateTestFile($operation, $module): void
    {
    	$content = file_get_contents($this->getTestStub());

    	$namespace = $this->findOperationTestNamespace($module);

    	$content = str_replace(
    		['{{namespace}}'],
    		[$namespace],
    		$content
    	);

    	$path = $this->findOperationTestPath($module, $operation.'Test');

    	$this->createFile($path, $content);
    }

    private function getTestStub(): string
    {
    	return __DIR__ . '/stubs/pest-test.stub';
    }
}
