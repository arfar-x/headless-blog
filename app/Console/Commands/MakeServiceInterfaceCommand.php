<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeServiceInterfaceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:service-interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an Interface for repository pattern.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ServiceInterface';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return app("path.services") . DIRECTORY_SEPARATOR
            . "stubs" . DIRECTORY_SEPARATOR . "ServiceInterface.stub";
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return "App\Services\Contracts";
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $class = $this->getNameInput();

        return app("path.services")
            . DIRECTORY_SEPARATOR . "Contracts"
            . DIRECTORY_SEPARATOR . $class 
            . DIRECTORY_SEPARATOR . $class . $this->type . ".php";
    }
}
