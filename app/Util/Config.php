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

    public function getPageLimit()
    {
        return $this->config['page_limit'];
    }

    public function getSupportMailId()
    {
        return $this->config['email']['supportMailId'];
    }
}
