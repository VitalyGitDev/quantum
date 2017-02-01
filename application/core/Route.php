<?php
namespace Application\Core;

use Application\Core\ServiceLocator;

//TODO: refactoring according to factory pattern.
class Router
{
    public $defaultController;

    public $defaultAction;

    public $action;

    public $action_param;

    public $controller;

    public $model;

    public function __construct()
    {
        $this->defaultController = 'desktop';
        $this->defaultAction = 'index';
    }

    public function start()
    {
        $address = explode('/',$_SERVER['REQUEST_URI']);
        switch($address[1]) {
            case "api" :
                $this->apiRouter($address, $_SERVER['REQUEST_METHOD']);
                break;
            default:
                $this->defaultRouter($address);
                break;
        }
    }

    //TODO: refactoring to some factory pattern class
    protected function apiRouter(array $address, $method)
    {
        $apiVersion = (! empty($address[2])) ? $address[2] : "v1";
        if ( ! empty($address[3]) ) {
            if (substr($address[3], -1) != 's') {
                $this->ErrorPage404();
            }

            if (! isset($address[4])) {
                $this->ErrorPage404();
            }

            $this->controller =  'Api\Rest\Controllers\\' . ucfirst(rtrim($address[3], 's')) . 'Controller';

            switch($method) {
              case "GET" :
                  if (!$address[4]) {
                      $this->action = 'actionIndex';
                  } else {
                      if ($address[4] * 1) {
                          $this->action = 'actionGet';
                          $this->action_param = (int)$address[4];
                      } else {
                          $this->ErrorPage404();
                      }
                  }
                  break;
              case "POST" :
                  $this->action = 'actionCreate';
                  break;
              case "PATCH" :
              case "PUT" :
                  $this->action = 'actionRenew';
                  if (! empty($address[4]) && ($address[4] * 1)) {
                      $this->action_param = (int)$address[4];
                  } else {
                      $this->ErrorPage404();
                  }
                  break;
              case "DELETE" :
                  $this->action = 'actionDelete';
                if (! empty($address[4])/* && ($address[4] * 1)*/) {
                      $this->action_param = $address[4];
                  } else {
                      $this->ErrorPage404();
                  }
                  break;
            }

        } else {
            $this->ErrorPage404();
        }

        if (!class_exists($this->controller)) {
            $this->ErrorPage404();
        }
//TODO: NEED TO SET DI-params in controller creation!!!
        $services = require_once(__DIR__ . '/../config/services.php');
        $controller = new $this->controller(new ServiceLocator($services));

        if ( method_exists($controller, $this->action) )
        {
            $action = $this->action;
            if (! empty($this->action_param)) {
                $controller->$action($this->action_param);
            } else {
                $controller->$action();
            }

        }
        else
        {
            $this->ErrorPage404();
        }
    }

    protected function defaultRouter(array $address)
    {
        $this->controller = ( ! empty($address[1]) ) ? 'Application\Controllers\\' . ucfirst($address[1]) . 'Controller' : 'Application\Controllers\\' . ucfirst($this->defaultController) . 'Controller';
        $this->action = ( ! empty($address[2]) ) ? 'action' . ucfirst($address[2]) : 'action' . ucfirst($this->defaultAction);

        if (!class_exists($this->controller)) {
            $this->ErrorPage404();
        }

        $services = require_once(__DIR__ . '/../config/services.php');
        $controller = new $this->controller(new ServiceLocator($services));

        if ( method_exists($controller, $this->action) )
        {
            $action = $this->action;
            $controller->$action();
        }
        else
        {
            $this->ErrorPage404();
        }
    }

    //TODO: refactoring to correct headers output.
    private function ErrorPage404()
    {
        echo "404";
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
    	  header("Status: 404 Not Found");
    	  header('Location:'.$host.'404');
        exit;
    }
}
