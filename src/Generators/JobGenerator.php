<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class JobGenerator extends Generator
{
    /**
     * @throws Exception
     */
    public function generate(string $job, string $module): bool
    {
        $job = Str::job($job);
        $module = Str::module($module);

        $path = $this->findJobPath($module, $job);

        if (file_exists($path)) {
            return false;
        }

        $namespace = $this->findJobNamespace($module);

        $content = file_get_contents(__DIR__ . "/stubs/job.stub");

        $content = str_replace(
            ['{{job}}', '{{namespace}}'],
            [$job, $namespace],
            $content
        );

        $this->createFile($path, $content);

        $this->generateTestFile($job, $module);

        return true;
    }

    private function generateTestFile($job, $module): void
    {
    	$content = file_get_contents($this->getTestStub());

    	$namespace = $this->findJobTestNamespace($module);

    	$content = str_replace(
    		['{{namespace}}'],
    		[$namespace],
    		$content
    	);

    	$path = $this->findJobTestPath($module, $job.'Test');

    	$this->createFile($path, $content);
    }

    private function getTestStub(): string
    {
    	return __DIR__ . '/stubs/pest-test.stub';
    }
}
