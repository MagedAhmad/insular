<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Generators\JobGenerator;

class GenerateJobCommand extends Command
{
    protected $signature = 'create:job 
                            {name : Class (Singular), e.g LoginJob}
                            {module : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new Job';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));
        $generator = new JobGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Job" . $name . " already exists!</error>");

            return ;
        }

        $this->output->writeln("<info>Job $name Created successfully!</info>");
    }
}
