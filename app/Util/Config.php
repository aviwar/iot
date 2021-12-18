<?php

namespace Iot\Util;

class Config
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getAppName()
    {
        return $this->config['app_name'];
    }

    public function getAppLog()
    {
        return $this->config['app_log'];
    }

    public function getDocsPath()
    {
        return $this->config['docs'];
    }

    public function getCustomUI()
    {
        return $this->config['custom_ui'];
    }
}
