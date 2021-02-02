<?php
namespace Iot\Util;

use \Exception;

class Sms
{
    protected $clientId;
    protected $apiKey;
    protected $senderId;

    public function __construct($clientId, $apiKey, $senderId)
    {
        $this->clientId = urlencode($clientId);
        $this->apiKey = urlencode($apiKey);
        $this->senderId = urlencode($senderId);
    }

    public function sendSms(array $numbers, $message)
    {
        try {
            $numbers = implode(',', $numbers);
            // $message = rawurlencode($message);

            $smsData = [
                'apikey' => $this->apiKey,
                'clientId' => $this->clientId,
                'sid' => $this->senderId,
                'msisdn' => $numbers,
                'msg' => $message,
                'fl' => 0,
                'gwid' => '2',
            ];

            $ch = curl_init('https://sms.nettyfish.com/vendorsms/pushsms.aspx');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $smsData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
