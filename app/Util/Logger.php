<?php

namespace Iot\Util;

use SplFileObject;

class Logger
{
    private $applog;
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        $logFileName = 'app_' . date('Y-m') . '.log';
        $applogPath = $this->config->getAppLog() . $logFileName;

        $this->applog = new SplFileObject($applogPath, 'a+');
    }

    public function log($message)
    {
        $this->formattedLog($message);
    }

    /*public function logException(\Exception $e)
    {
        $this->formattedLog($e->getMessage());
        $this->formattedLog($e->getTraceAsString());
    }*/

    private function formattedLog($message)
    {
        $now = new \DateTime();
        $dateTime = $now->format('Y-m-d H:i:s');
        $formattedMessage = json_encode([
            'toolname' => $this->config->getAppName(),
            'user IP' => $_SERVER['REMOTE_ADDR'],
            'time' => $dateTime,
            'message' => $message,
        ]);

        $this->logMessage($formattedMessage);
    }

    private function logMessage($data = null)
    {
        $this->applog->fwrite($data . "\n");
    }
}
