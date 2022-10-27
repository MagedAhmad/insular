<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Generators\ExceptionGenerator;

class GenerateExceptionCommand extends Command
{
    protected $signature = 'create:exception 
                            {name : Class (Singular), e.g UserNotFoundException}
                            {module : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new exception';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));
        $generator = new ExceptionGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Exception" . $name . " already exists!</error>");

            return ;
        }

        $this->output->writeln("<info>Exception $name Created successfully!</info>");
    }
}
