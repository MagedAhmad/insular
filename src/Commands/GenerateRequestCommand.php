<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Helpers\FinderTrait;
use MagedAhmad\Insular\Generators\RequestGenerator;

class GenerateRequestCommand extends Command
{
    use FinderTrait;

    protected $signature = 'create:request 
                            {name : Class (Singular), e.g UserRequest}
                            {module : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new request';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));

        $path = $this->findRequestPath($module, $name);

        $generator = new RequestGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Request " . $name . " already exists in " . $module ."!</error>");

            return ;
        }

        $this->info("\n".'Find it at <comment>'.$path.'</comment>'."\n");
    }
}
