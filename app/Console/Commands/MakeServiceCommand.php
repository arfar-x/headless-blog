<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create necessary files and classes for Repository pattern.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return app("path.services") . DIRECTORY_SEPARATOR
            . "stubs" . DIRECTORY_SEPARATOR . "Service.stub";
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
        return "App\Services";
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
            . DIRECTORY_SEPARATOR . $class 
            . DIRECTORY_SEPARATOR . $class . $this->type . ".php";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        parent::handle();

        if ($this->option('all')) {
            
            $this->input->setOption('model', true);
            $this->input->setOption('repo', true);
            $this->input->setOption('interface', true);
        }

        if ($this->option('model')) {
            $this->call('make:model', ['name' => $this->getNameInput()]);
        }

        if ($this->option('repo')) {
            $this->call('make:repository', ['name' => $this->getNameInput()]);
        }

        if ($this->option('interface')) {
            $this->call('make:service-interface', ['name' => $this->getNameInput()]);
        }

        return 0;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a Model, Repository, and ServiceInterface for the serivce.'],
            ['model', 'm', InputOption::VALUE_NONE, 'Generate a Model for the service.'],
            ['repo', 'r', InputOption::VALUE_NONE, 'Generate a Repository for the service.'],
            ['interface', 'i', InputOption::VALUE_NONE, 'Generate a ServiceInterface for the service.'],
        ];
    }
}
