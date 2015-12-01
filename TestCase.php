<?php

namespace Soothsayer;

use Soothsayer\Manager\ClassManager;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Process tests or update code
     * @var boolean
     */
    public static $processTest = true;

    /**
     * Create a new instance of a class
     *
     * @param  string $namespace Class to create
     * @param  array  $args      Arguments for the controller
     *
     * @return mixed
     */
    public function createInstance($namespace, array $args)
    {
        if (self::$processTest) {
            $reflection = new \ReflectionClass($namespace);

            return $reflection->newInstanceArgs($args);
        }

        return new ClassManager($namespace, $args);
    }
}
