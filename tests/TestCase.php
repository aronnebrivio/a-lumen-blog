<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
        /*foreach (get_declared_classes() as $class) {
            try {
                $reflection = new \ReflectionClass($class);
                if (
                    !$reflection->isAbstract()
                    && is_subclass_of($class, Model::class)
                    && $reflection->hasMethod('flushHooks')
                    && !in_array(Mockery\MockInterface::class, class_implements($class))
                ) {
                    $class::flushHooks();
                    $class::bootMappable();
                }
            } catch (ReflectionException $e) {
            }
        }*/
    }
}
