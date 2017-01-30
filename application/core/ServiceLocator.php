<?php
namespace Application\Core;

class ServiceLocator
{
    protected $services = [];

    protected $container = [];

    public function __construct(array $services)
    {
        $this->services = $services;
    }

    public function get($alias)
    {
        if (empty($this->container[$alias])) {
            try {
                $className = $this->services[$alias]['class'];
                $this->container[$alias] = new $className(...$this->services[$alias]['args']);
            } catch (Exception $e) {
                echo 'We got Exception: ', $e->getMessage(), "\n";
            }
        }

        return $this->container[$alias];
    }
/*
    public static function register()
    {

    }
*/
}
