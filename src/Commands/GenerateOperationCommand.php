<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Generators\OperationGenerator;

class GenerateOperationCommand extends Command
{
    protected $signature = 'create:operation 
                            {name : Class (Singular), e.g LoginOperation}
                            {module : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new Operation';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));
        $generator = new OperationGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Operation" . $name . " already exists!</error>");

            return ;
        }

        $this->output->writeln("<info>Operation $name Created successfully!</info>");
    }
}
