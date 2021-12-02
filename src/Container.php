<?php

declare(strict_types=1);

namespace TicTacToe;

use Closure;
use Exception;

class Container
{
    private static ?Container $_instance = null;

    private array $_resolved = [];
    private array $_bindings = [];

    /**
     *
     * @return \TicTacToe\Container
     */
    public static function getInstance(): Container
    {
        return self::$_instance ?? self::$_instance = new static();
    }

    /**
     *
     * @param string $abstract
     * @param \Closure $closure
     * @return self
     */
    public function bind(string $abstract, Closure $closure): self
    {
        $this->_bindings[$abstract] = $closure;

        return $this;
    }

    /**
     *
     * @param string $abstract
     * @return mixed
     */
    public function make(string $abstract): mixed
    {
        if (isset($this->_resolved[$abstract])) {
            return $this->_resolved[$abstract];
        }

        if (!isset($this->_bindings[$abstract])) {
            throw new Exception("No binding for {$abstract}");
        }

        $closure = $this->_bindings[$abstract];
        $object = $closure($this);

        $this->_resolved[$abstract] = $object;

        return $object;
    }

    /**
     *
     * @param string $abstract
     * @param \Closure $closure
     * @return void
     */
    public function factory(string $abstract, Closure $closure): mixed
    {
        return $this->bind($abstract, $closure)->make($abstract);
    }
}
