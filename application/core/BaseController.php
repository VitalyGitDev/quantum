<?php
namespace Application\Core;

use Application\Core\ServiceLocator;

abstract class BaseController
{
    public $view;

    protected $services;

    public function __construct(ServiceLocator $services)
    {
        $this->view = new View();
        $this->services = $services;
    }

}
