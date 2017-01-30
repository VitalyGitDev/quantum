<?php
namespace Application\Services;

use Application\Core\Service;

class AppConfig extends Service
{
    protected $config = [];

    public function __construct(string $appConfigPath)
    {
        if (! empty($appConfigPath)) {
            $this->config = require_once($appConfigPath);
        } else {
            throw new Exception("Error Processing Request for appConfig file path.", 1);
        }
    }

    public function get($key)
    {
        if (!empty($this->config[$key])) {
            return $this->config[$key];
        } else {
            return false;
        }
    }

    public function all()
    {
        return $this->config;
    }
}
