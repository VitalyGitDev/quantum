<?php

Class Autoloader
{
    const CONTROLLERS_PATH = __DIR__ . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;

    const MODELS_PATH = __DIR__ . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR;

    const CORE_PATH = __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR;

    const SERVICES_PATH = __DIR__ . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR;

    const VIEWS_PATH = __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;

    const API_CONTROLLERS_PATH = __DIR__ . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'rest' . DIRECTORY_SEPARATOR  . 'v1' . DIRECTORY_SEPARATOR  . 'controllers' . DIRECTORY_SEPARATOR;

    //TODO: make as Services!!! and with autoload.
    protected $namespaceMap = [
        'Application\Controllers\BaggageController' => self::CONTROLLERS_PATH . 'BaggageController.php',
        'Application\Controllers\DesktopController' => self::CONTROLLERS_PATH . 'DesktopController.php',

        'Application\Core\View' => self::CORE_PATH . 'View.php',
        'Application\Core\DbConnector' => self::CORE_PATH . 'DbConnector.php',
        'Application\Core\Router' => self::CORE_PATH . 'Route.php',
        'Application\Core\Model' => self::CORE_PATH . 'Model.php',
        'Application\Core\BaseController' => self::CORE_PATH . 'BaseController.php',
        'Application\Core\ServiceLocator' => self::CORE_PATH . 'ServiceLocator.php',
        'Application\Core\Service' => self::CORE_PATH . 'Service.php',
        'Application\Core\RESTController' => self::CORE_PATH . 'RESTController.php',

        'Application\Services\AppConfig' => self::SERVICES_PATH . 'appConfig.php',

        'Api\Rest\Controllers\ResourceController' => self::API_CONTROLLERS_PATH . 'ResourceController.php',

        'Application\Models\BaggageModel' => self::MODELS_PATH . 'BaggageModel.php',
        'Application\Models\ResourceModel' => self::MODELS_PATH . 'ResourceModel.php',
    ];

    public function load()
    {
        spl_autoload_register([$this, 'autoload']);
    }

    protected function autoload($class)
    {
        if (!empty($this->namespaceMap[$class])) {
            $filePath = $this->namespaceMap[$class];
            require_once $filePath;
            return true;
        }

        return false;
    }
}
