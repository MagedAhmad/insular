<?php

namespace MagedAhmad\Insular\Commands;

use Exception;
use Illuminate\Console\Command;
use MagedAhmad\Insular\Helpers\Str;
use MagedAhmad\Insular\Helpers\FinderTrait;
use MagedAhmad\Insular\Generators\TypeGenerator;

class GenerateTypeCommand extends Command
{
    use FinderTrait;

    protected $signature = 'create:type 
                            {name : Class (Singular), e.g UserData}
                            {module : Class (Singular), e.g Auth}';

    protected $description = 'Generate a new type request';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->input->getArgument('name');
        $module = Str::studly($this->input->getArgument('module'));

        $path = $this->findTypePath($module, $name);

        $generator = new TypeGenerator();

        if(!$generator->generate($name, $module)) {
            $this->output->writeln("<error>Type " . $name . " already exists in " . $module ."!</error>");

            return ;
        }

        $this->info("\n".'Find it at <comment>'.$path.'</comment>'."\n");
    }
}
