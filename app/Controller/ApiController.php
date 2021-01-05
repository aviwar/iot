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

        $this->logger->log('Sensor data: ' . json_encode($data));

        $sensorId = $this->apiRepository->addSensor($data);
        if (empty($sensorId)) {
            throw new \Exception('Unable to add sensor data');
        }

        $responseData['status'] = 'success';
        $responseData['message'] = 'Sensor data added.';

        return $response->withJson($responseData, 201);
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
        if(empty($data['serialData'])) {
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
