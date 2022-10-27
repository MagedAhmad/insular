<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class FeatureGenerator extends Generator
{
    /**
     * @throws Exception
     */
    public function generate(string $feature, string $module): bool
    {
        $feature = Str::feature($feature);
        $module = Str::module($module);

        $path = $this->findFeaturePath($module, $feature);

        if (file_exists($path)) {
            return false;
        }

        $namespace = $this->findFeatureNamespace($module);

        $content = file_get_contents(__DIR__ . "/stubs/feature.stub");

        $content = str_replace(
            ['{{feature}}', '{{namespace}}'],
            [$feature, $namespace],
            $content
        );

        $this->createFile($path, $content);

        $this->generateTestFile($feature, $module);

        return true;
    }

    private function generateTestFile($feature, $module): void
    {
    	$content = file_get_contents($this->getTestStub());

    	$namespace = $this->findFeatureTestNamespace($module);

    	$content = str_replace(
    		['{{namespace}}'],
    		[$namespace],
    		$content
    	);

    	$path = $this->findFeatureTestPath($module, $feature.'Test');

    	$this->createFile($path, $content);
    }

    private function getTestStub(): string
    {
    	return __DIR__ . '/stubs/pest-test.stub';
    }
}
