<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Generators\ModuleGenerator;

class GenerateModuleCommand extends Command
{
    protected $signature = 'create:module 
                            {name : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new Module';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $generator = new ModuleGenerator();

        if(!$generator->generate($name)) {
            $this->output->writeln("<error>Module already exists!</error>");

            return ;
        }

        $this->output->writeln("<info>Module $name Created successfully!</info>");
    }
}
