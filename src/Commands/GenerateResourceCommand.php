<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Helpers\FinderTrait;
use MagedAhmad\Insular\Generators\ResourceGenerator;

class GenerateResourceCommand extends Command
{
    use FinderTrait;

    protected $signature = 'create:resource 
                            {name : Class (Singular), e.g UserResource}
                            {module : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new resource';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));

        $path = $this->findResourcePath($module, $name);

        $generator = new ResourceGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Resource " . $name . " already exists in " . $module ."!</error>");

            return ;
        }

        $this->info("\n".'Find it at <comment>'.$path.'</comment>'."\n");
    }
}
