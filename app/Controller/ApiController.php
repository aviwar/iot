<?php
namespace Iot\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ApiController extends BaseController
{
    public function addSensor(Request $request, Response $response)
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
}
