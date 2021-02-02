<?php
namespace Iot\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ApiController extends BaseController
{
    public function postSensorData(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data['userId'] = $request->getAttribute('userId');
        $mobileNumber = $request->getAttribute('mobileNumber');

        $this->logger->log('Sensor data: ' . json_encode($data));

        $sensorId = $this->apiRepository->addSensor($data);
        if (empty($sensorId)) {
            throw new \Exception('Unable to add sensor data');
        }

        if (!empty($mobileNumber)) {
            $this->sendSensorDataSms($mobileNumber, $data);
        }

        $responseData['status'] = 'success';
        $responseData['message'] = 'Sensor data added.';

        return $response->withJson($responseData, 201);
    }

    private function sendSensorDataSms($mobileNumber, $sensorData)
    {
        unset($sensorData['userId']);

        $mobileNumbers = [$mobileNumber];
        $message = json_encode($sensorData);

        $smsResponse = $this->sms->sendSms($mobileNumbers, $message);

        $this->logger->log('SMS Response: ' . json_encode($smsResponse));
    }

    public function getSensorData(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');
        $date = $request->getAttribute('date');
        $sensorData = $this->apiRepository->getSensorData($userId, $date);
        if (empty($sensorData)) {
            throw new \Exception('No data found!', 404);
        }

        $responseData['status'] = 'success';
        $responseData['data'] = $sensorData;

        return $response->withJson($responseData, 200);
    }

    public function updateDeviceStatus(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data['user_id'] = $request->getAttribute('userId');

        $deviceId = $this->apiRepository->addDevice($data);
        if (empty($deviceId)) {
            throw new \Exception('Unable to update device status');
        }

        $responseData['status'] = 'success';
        $responseData['message'] = 'Device status updated.';

        return $response->withJson($responseData, 201);
    }

    public function getDeviceData(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');
        $deviceData = $this->userRepository->getDeviceByUserId($userId);
        if (empty($deviceData)) {
            throw new \Exception('No data found!', 404);
        }

        $responseData['status'] = 'success';
        $responseData['data'] = $deviceData;

        return $response->withJson($responseData, 200);
    }

    public function postDeviceSerialData(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        if (empty($data['serialData'])) {
            throw new \Exception('Invalid serial data', 400);
        }

        $data['userId'] = $request->getAttribute('userId');

        $this->logger->log('Device Serial data: ' . json_encode($data));

        $serialId = $this->apiRepository->addDeviceSerialData($data);
        if (empty($serialId)) {
            throw new \Exception('Unable to send serial data');
        }

        $responseData['status'] = 'success';
        $responseData['message'] = 'Serial data sent!';

        return $response->withJson($responseData, 201);
    }

    public function getDeviceSerialData(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');
        $serialData = $this->apiRepository->getDeviceSerialData($userId);
        if (empty($serialData)) {
            throw new \Exception('No data found!', 404);
        }

        $this->apiRepository->updateSerialDataStatus($serialData);

        $responseData['status'] = 'success';
        $responseData['data'] = $serialData;

        return $response->withJson($responseData, 200);
    }

    public function getLocationData(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');
        $date = $request->getAttribute('date');
        $locationData = $this->apiRepository->getLocationData($userId, $date);
        if (empty($locationData)) {
            throw new \Exception('No data found!', 404);
        }

        $responseData['status'] = 'success';
        $responseData['data'] = $locationData;

        return $response->withJson($responseData, 200);
    }

    public function postLocationData(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        if (empty($data['longitude']) || empty($data['latitude'])) {
            throw new \Exception('Invalid data', 400);
        }

        $data['userId'] = $request->getAttribute('userId');
        // $data['address'] = $this->getAddress($data['latitude'], $data['longitude']);
        $this->logger->log('Location data: ' . json_encode($data));

        $locationId = $this->apiRepository->addLocationData($data);
        if (empty($locationId)) {
            throw new \Exception('Unable to add location data');
        }

        $responseData['status'] = 'success';
        $responseData['message'] = 'Location data added!';

        return $response->withJson($responseData, 201);
    }

    private function getAddress($latitude, $longitude)
    {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json';
        $apiUrl = sprintf(
            '%s?latlng=%s,%s&sensor=false',
            $url,
            $latitude,
            $longitude
        );

        $json = @file_get_contents($apiUrl);
        $data = json_decode($json);

        $status = $data->status;
        if ($status == 'OK') {
            return $data->results[0]->formatted_address;
        } else {
            return null;
        }
    }

    public function postResetData(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');
        $isDeleted = $this->apiRepository->resetSensorData($userId);
        if (empty($isDeleted)) {
            throw new \Exception('Unable to reset data!', 404);
        }

        $responseData['status'] = 'success';
        $responseData['message'] = 'Sensor Data resetted';

        return $response->withJson($responseData, 200);
    }
}
