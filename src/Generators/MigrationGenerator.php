<?php 

namespace MagedAhmad\Insular\Generators;

use MagedAhmad\Insular\Helpers\Str;

class MigrationGenerator extends Generator 
{
    public function generate(string $name, string $module): bool
    {
        $module = Str::module($module);

        $path = $this->findMigrationPath($module, $name);

        if (file_exists($path)) {
            return false;
        }
        
        $content = file_get_contents($this->getStub());
        $content = str_replace(
             ['{{migration}}'],
             [$name],
             $content
         );

        $this->createFile($path, $content);

        return true;
    }


    protected function getStub(): string
    {
        return __DIR__ . '/stubs/migration.stub';
    }
}