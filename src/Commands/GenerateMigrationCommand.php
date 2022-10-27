<?php

namespace MagedAhmad\Insular\Commands;

use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Helpers\FinderTrait;
use MagedAhmad\Insular\Generators\MigrationGenerator;

class GenerateMigrationCommand extends Command
{
    use FinderTrait;

    protected $signature = 'create:migration 
                            {name : Class (Singular), e.g create_users_table}
                            {module : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new migration';

    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));

        $path = $this->findMigrationPath($module, $name);

        $generator = new MigrationGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Migration " . $name . " already exists in " . $module ."!</error>");

            return ;
        }

        $this->info("\n".'Find it at <comment>'.$path.'</comment>'."\n");
    }
}
