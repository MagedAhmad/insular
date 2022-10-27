<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Generators\FeatureGenerator;

class GenerateFeatureCommand extends Command
{
    protected $signature = 'create:feature 
                            {name : Class (Singular), e.g LoginFeature}
                            {module : Class (Singular), e.g AuthFeature}';

    protected $description = 'Generate a new Feature';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));
        $generator = new FeatureGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Feature" . $name . " already exists!</error>");

            return ;
        }

        $this->output->writeln("<info>Feature $name Created successfully!</info>");
    }
}
