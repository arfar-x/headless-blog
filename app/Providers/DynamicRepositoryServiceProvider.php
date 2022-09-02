<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DynamicRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Services that are injected to IoC Container.
     *
     * @var array
     */
    protected $services = [];

    /**
     * Services' interfaces.
     *
     * @var array
     */
    protected $interfaces = [];

    /**
     * Services' dependencies that must be injected.
     *
     * @var array
     */
    protected $dependencies = [];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance('path.services', app_path('Services'));

        $this->services     = config('repos.services');
        $this->interfaces   = config('repos.interfaces');
        $this->dependencies = config('repos.dependencies');

        foreach ($this->interfaces as $serviceName => $interface) {
            $this->app->singletonIf($interface, function () use ($serviceName) {
                /**
                 * ! Uncovered mechanism (not tested); what if that a service has several dependencies (or Variadic).
                 *  E.g. $object = new ServiceClass(new Dependency, new SomethingElse, new OneMoreClass)
                 */
                return new $this->services[$serviceName]($this->extractDependencies($serviceName));
            });
        }
    }

    /**
     * Extract and instantiate service's dependencies.
     *
     * @return mixed
     */
    protected function extractDependencies(string $serviceName)
    {
        $serviceDependencies = $this->dependencies[$serviceName];

        if (is_array($serviceDependencies)) {

            foreach ($serviceDependencies as $interface => $dependency) {

                $this->app->singletonIf($interface, function () use ($dependency) {
                    return new $dependency;
                });

                return $this->app->make($interface);
            }
        } else {

            $this->app->singletonIf($serviceDependencies);

            return $this->app->make($serviceDependencies);
        }
    }
}
