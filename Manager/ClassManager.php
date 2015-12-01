<?php

namespace Soothsayer\Manager;

use League\Flysystem\Filesystem;

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
     * Constructor
     * @param string $namespace Class namespace
     * @param array  $args      Class constructor arguments
     */
    public function __construct($namespace, array $args)
    {
        $this->namespace = $namespace;
        $this->args = $args;
        $this->path = getcwd() . '/src' . str_replace('\\', '/', $namespace) . '.php';

        if (!file_exists($this->path)) {
            if (!file_exists(dirname($this->path))) {
                mkdir(dirname($this->path), 0755, true);
            }

            file_put_contents($this->path, $this->getString());
        }
    }

    /**
     * Get the class string
     *
     * @return string
     */
    private function getString()
    {
        $elements = explode('\\', $this->namespace);
        array_shift($elements);
        $className = array_pop($elements);

        $parameters = '';
        for($i = 0; $i < count($this->args); $i++) {
            if ($i !== 0) {
                $parameters = $parameters . ', ';
            }

            $parameters = $parameters . '$arg' . $i;
        }

        return '<?php

namespace ' . join('\\', $elements) . ';

class ' . $className .'
{
    public function __construct(' . $parameters .')
    {

    }
}
        ';
    }
}
