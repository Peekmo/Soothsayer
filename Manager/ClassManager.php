<?php

namespace Soothsayer\Manager;

class ClassManager
{
    /**
     * Class namespace
     * @var string
     */
    private $namespace;

    /**
     * Class constructor arguments
     * @var array
     */
    private $args;

    /**
     * Constructor
     * @param string $namespace Class namespace
     * @param array  $args      Class constructor arguments
     */
    public function __construct($namespace, array $args)
    {
        $this->namespace = $namespace;
        $this->args = $args;
    }
}
