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

        if (!empty($data['sms']) && !empty($mobileNumber)) {
            $this->sendSensorDataSms($mobileNumber, $data);
        }

        $responseData['status'] = 'success';
        $responseData['message'] = 'Sensor data added.';

        return $response->withJson($responseData, 201);
    }

    private function sendSensorDataSms($mobileNumber, $sensorData)
    {
        unset($sensorData['userId']);
        unset($sensorData['sms']);

        $mobileNumbers = [$mobileNumber];
        // $message = json_encode($sensorData);

        $message = '';
        for ($i = 1; $i <= 8; $i++) {
            $key = 'sensor' . $i;
            $message .= "sensor $i $sensorData[$key] ";
        }

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

        $this->logger->log('Update Device data: ' . json_encode($data));

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
        $this->logger->log('Location data: ' . json_encode($data));

        $locationId = $this->apiRepository->addLocationData($data);
        if (empty($locationId)) {
            throw new \Exception('Unable to add location data');
        }

        $responseData['status'] = 'success';
        $responseData['message'] = 'Location data added!';

        return $response->withJson($responseData, 201);
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

    public function getSensorTypeData(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');
        $sensorData = $this->apiRepository->getUserSensorTypeData($userId);
        if (empty($sensorData)) {
            throw new \Exception('No data found!', 404);
        }

        $this->apiRepository->updateUserSensorTypeStatus($userId);

        $sensorData = $this->processSensorTypeData($sensorData);

        $responseData['status'] = 'success';
        $responseData['data'] = $sensorData;
        $responseData['data']['projectTitle'] = $this->userRepository->getProjectTitleByUserId(
            $userId
        );

        return $response->withJson($responseData, 200);
    }

    private function processSensorTypeData($data)
    {
        $sensorTypeData = $this->apiRepository->getSensorTypeData();

        for ($i = 1; $i <= 8; $i++) {
            $sensorNameKey = 'sensor' . $i . '_name';
            $sensorTypeKey = 'sensor' . $i . '_type';

            $sensorName = '';
            $sensorType = '';
            if (!empty($data[$sensorNameKey])) {
                // search sensor key value in sensor type array
                $searchKey = array_search(
                    $data[$sensorNameKey],
                    array_column($sensorTypeData, 'sensor_type_id')
                );
                $sensorName = $sensorTypeData[$searchKey]['sensor_name'];
                $sensorType = $sensorTypeData[$searchKey]['sensor_type'];
            }
            $data[$sensorNameKey] = $sensorName;
            $data[$sensorTypeKey] = $sensorType;
        }

        return $data;
    }

    public function readFile(Request $request, Response $response, $args)
    {
        $fileType = $args['fileName'];

        if ($fileType === 'Analog') {
            $fileName = 'Analog_sensor_code.txt';
        } else {
            $fileName = 'Digital_sensor_code.txt';
        }
        
        echo htmlentities(file_get_contents($this->config->getDocsPath() . $fileName));        
        exit;
    }
    
    
    public function downloadFile(Request $request, Response $response, $args)
    {
        $fileType = $args['fileName'];

        if ($fileType === 'Analog') {
            $fileName = 'Analog_sensor_code.txt';
        } else {
            $fileName = 'Digital_sensor_code.txt';
        }

        $filePath = $this->config->getDocsPath() .  $fileName;
        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"" . basename($filePath) . "\""); 
        readfile($filePath);        
        exit;
    }
}
