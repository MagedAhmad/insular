<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Helpers\FinderTrait;
use MagedAhmad\Insular\Generators\ControllerGenerator;

class GenerateControllerCommand extends Command
{
    use FinderTrait;

    protected $signature = 'create:controller 
                            {name : Class (Singular), e.g LoginController}
                            {module : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new Controller';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));
        $generator = new ControllerGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Controller " . $name . " already exists in " . $module ."!</error>");

            return ;
        }

        $path = $this->findControllerPath($module, $name);

        $this->info("\n".'Find it at <comment>'.$path.'</comment>'."\n");
    }
}
