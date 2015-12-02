<?php

namespace Soothsayer\Manager;

use League\Flysystem\Filesystem;
use Soothsayer\Manager\PropertyManager;

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
     * Path to the PHP file
     * @var string
     */
    private $path;

    /**
     * All class's properties
     * @var array
     */
    private $properties = array();

    /**
     * Constructor
     * @param string $namespace Class namespace
     * @param array  $args      Class constructor arguments
     */
    public function __construct($namespace, array $args)
    {
        $this->namespace = $namespace;
        $this->args = $args;
        $this->path = getcwd() . '/src' . str_replace('\\', '/', $namespace) . '.php';

        for($i = 0; $i < count($this->args); $i++) {
            $this->properties[] = new PropertyManager('arg' . $i, $args[$i]);
        }

        if (!file_exists($this->path)) {
            if (!file_exists(dirname($this->path))) {
                mkdir(dirname($this->path), 0755, true);
            }

            file_put_contents($this->path, $this->getString());
        }
    }

    private function buildDeclarations()
    {
        $content = '';

        foreach ($this->properties as $property) {
            $content =  $content . '    ' . $property->getDeclaration() . PHP_EOL;
        }

        return $content;
    }

    private function buildGetterSetters()
    {
        $content = '';

        foreach ($this->properties as $property) {
            $content = $content . $property->getGetterSetter();
        }

        return $content;
    }

    private function buildConstructorContent()
    {
        $content = '';

        foreach ($this->properties as $property) {
            $content = $content . '        ' . '$this->' . $property->getName() . ' = $' . $property->getName() . ';' . PHP_EOL;
        }

        return $content;
    }

    /**
     * Get the class string
     *
     * @return string
     */
    private function getString()
    {
        $elements = explode('\\', $this->namespace);

        if ($elements[0] == '') {
            array_shift($elements);
        }

        $className = array_pop($elements);

        $parameters = '';
        for($i = 0; $i < count($this->properties); $i++) {
            if ($i !== 0) {
                $parameters = $parameters . ', ';
            }

            $parameters = $parameters . '$' . $this->properties[$i]->getName();
        }

        return '<?php

namespace ' . join('\\', $elements) . ';

class ' . $className .'
{
'. $this->buildDeclarations() .'
    public function __construct(' . $parameters .')
    {
'. $this->buildConstructorContent() .'
    }
'. $this->buildGetterSetters() .'
}
        ';
    }
}
