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

    public function getName()
    {
        return $this->name;
    }

    public function getDeclaration()
    {
        return sprintf('private $%s;', $this->name);
    }

    public function getGetterSetter()
    {
        return sprintf('
    public function get%1$s()
    {
        return $this->%2$s;
    }

    public function set%1$s($%2$s)
    {
        $this->%2$s = $%2$s;
    }
        ', ucfirst($this->name), $this->name
        );
    }
}
