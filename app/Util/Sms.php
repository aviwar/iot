<?php

namespace Iot\Util;

use \Exception;

class Sms
{
    protected $clientId;
    protected $apiKey;
    protected $senderId;
    protected $url;

    public function __construct($clientId, $apiKey, $senderId, $url)
    {
        $this->clientId = $clientId;
        $this->apiKey = $apiKey;
        $this->senderId = $senderId;
        $this->url = $url;
    }

    public function sendSms(array $numbers, $message)
    {
        try {
            $numbers = implode(',', $numbers);

            $smsData = [
                'ApiKey' => $this->apiKey,
                'ClientId' => $this->clientId,
                'SenderId' => $this->senderId,
                'MobileNumbers' => $numbers,
                'Message' => $message,
            ];

            $headers = array(
                "Content-Type: application/json",
            );

            $ch = curl_init($this->url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($smsData));
            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response, true);
        } catch (Exception $e) {
            $response['status'] = 'failure';
            $response['message'] =
                'Sms Could not be sent. Error: ' . $e->getMessage();
        }

        return $response;
    }
}
