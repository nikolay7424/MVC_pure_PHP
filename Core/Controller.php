<?php


namespace Core;


abstract class Controller
{
    protected $routeParams = [];

    /**
     * Controller constructor.
     * @param array $routeParams
     */
    public function __construct(array $routeParams)
    {
        $this->routeParams = $routeParams;
    }

    /**
     * @param $name
     * @param $args
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method))
        {
            if ($this->before() !== false)
            {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        }else{
            throw new \Exception("Method $method not found in" .
                get_class($this) .  "controller.");
        }
    }

    protected function before()
    {

    }

    protected function after()
    {

    }
}