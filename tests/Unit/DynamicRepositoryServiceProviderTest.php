<?php

namespace Tests\Unit;

use Tests\HasUser;
use Tests\TestCase;

class DynamicRepositoryServiceProviderTest extends TestCase
{
    use HasUser;

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
     * Services' repositories.
     *
     * @var array
     */
    protected $repositories = [];

    /**
     * Services' dependencies that must be injected.
     *
     * @var array
     */
    protected $dependencies = [];

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->createUser();

        $this->services     = config('repos.services');
        $this->interfaces   = config('repos.interfaces');
        $this->repositories = config('repos.repositories');
        $this->dependencies = config('repos.dependencies');
    }

    /**
     * Test that all services are binded to the container.
     *
     * @return void
     */
    public function testServicesAreBinded()
    {
        $this->actingAs($this->user);

        foreach ($this->interfaces as $name => $interface) {

            $this->assertTrue($this->app->bound($interface));
        }
    }
}
