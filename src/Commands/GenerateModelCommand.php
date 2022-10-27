<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Helpers\FinderTrait;
use MagedAhmad\Insular\Generators\ModelGenerator;

class GenerateModelCommand extends Command
{
    use FinderTrait;

    protected $signature = 'create:model 
                            {name : Class (Singular), e.g User}
                            {module : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new model';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));

        $path = $this->findModelPath($module, $name);

        $generator = new ModelGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Model " . $name . " already exists in " . $module ."!</error>");

            return ;
        }

        $this->info("\n".'Find it at <comment>'.$path.'</comment>'."\n");
    }
}
