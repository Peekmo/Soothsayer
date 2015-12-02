<?php

namespace Soothsayer\Manager;

class PropertyManager
{
    /**
     * Property name
     * @var string
     */
    private $name;

    /**
     * Property default value (initialized in constructor)
     * @var mixed
     */
    private $defaultValue;

    /**
     * Constructor
     * @param string $name
     * @param mixed  $defaultValue
     */
    public function __construct($name, $defaultValue)
    {
        $this->name         = $name;
        $this->defaultValue = $defaultValue;
    }
}
