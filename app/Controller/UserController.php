<?php
namespace Iot\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends BaseController
{
    
    public function dashboard(Request $request, Response $response)
    {
        $data['page']['title'] = 'Home';
        $userId = $request->getAttribute('userId');
        $data['projectTitle'] = $this->userRepository->getProjectTitleByUserId(
            $userId
        );

        return $this->view->render($response, 'user/dashboard.twig', $data);
    }

    public function viewProjectTitle(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Update Project Title';
        $data['projectTitle'] = $this->userRepository->getProjectTitleByUserId(
            $userId
        );

        return $this->view->render($response, 'user/view_title.twig', $data);
    }

    public function updateProjectTitle(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data['userId'] = $request->getAttribute('userId');

        $this->logger->log('Project Title data: ' . json_encode($data));

        $isUpdated = $this->userRepository->updateProjectTitle($data);
        if ($isUpdated === false) {
            $type = 'error';
            $msg = 'Some problem occurred, please try again.';
        } else {
            $type = 'success';
            $msg = 'Updated successfully.';
        }

        $this->flash->addMessage($type, $msg);

        return $response->withRedirect($this->router->pathFor('title'));
    }

    public function viewMobileNumber(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Update Mobile Number';
        $data['mobileNumber'] = $this->userRepository->getMobileNumberByUserId(
            $userId
        );

        return $this->view->render(
            $response,
            'user/view_mobile_number.twig',
            $data
        );
    }

    public function updateMobileNumber(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data['userId'] = $request->getAttribute('userId');

        $this->logger->log('User Mobile Number: ' . json_encode($data));

        $isUpdated = $this->userRepository->updateMobileNumber($data);
        if ($isUpdated === false) {
            $type = 'error';
            $msg = 'Some problem occurred, please try again.';
        } else {
            $type = 'success';
            $msg = 'Updated successfully.';
        }

        $this->flash->addMessage($type, $msg);

        return $response->withRedirect($this->router->pathFor('mobile'));
    }

    public function viewSensorList(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Real Time Sensor Values';
        $data['sensors'] = $this->userRepository->getSensorByUserId($userId);
        $data['setting'] = $this->userRepository->getSensorSettingByUserId(
            $userId
        );
        $data['setting']['sensor_count'] =
            $data['setting']['sensor_count'] ?? 8;

        return $this->view->render($response, 'user/view_sensors.twig', $data);
    }

    public function viewDeviceSwitch(Request $request, Response $response)
    {
        $data['page']['title'] = 'Device On/Off Buttons';

        $userId = $request->getAttribute('userId');
        $data['device'] = $this->userRepository->getDeviceByUserId($userId);
        $data['setting'] = $this->userRepository->getDeviceSettingByUserId(
            $userId
        );
        $data['setting']['device_count'] =
            $data['setting']['device_count'] ?? 6;

        return $this->view->render(
            $response,
            'user/view_device_switch.twig',
            $data
        );
    }

    public function viewDeviceSerialData(Request $request, Response $response)
    {
        $data['page']['title'] = 'Send Serial Data to Device';

        return $this->view->render(
            $response,
            'user/view_device_data_form.twig',
            $data
        );
    }

    public function viewLocation(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Location Summary';
        $data['locations'] = $this->userRepository->getLocationByUserId(
            $userId
        );

        return $this->view->render(
            $response,
            'user/view_locations.twig',
            $data
        );
    }

    public function viewReset(Request $request, Response $response)
    {
        $data['page']['title'] = 'Reset Sensor Data';

        return $this->view->render(
            $response,
            'user/view_reset_form.twig',
            $data
        );
    }

    public function viewSensorSetting(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Sensors';
        $data['setting'] = $this->userRepository->getSensorSettingByUserId(
            $userId
        );

        return $this->view->render(
            $response,
            'user/view_sensor_setting.twig',
            $data
        );
    }

    public function updateSensorSetting(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data['user_id'] = $request->getAttribute('userId');

        $this->logger->log('Sensor settings data: ' . json_encode($data));

        $isUpdated = $this->userRepository->updateSensorSetting($data);
        if ($isUpdated === false) {
            $type = 'error';
            $msg = 'Some problem occurred, please try again.';
        } else {
            $type = 'success';
            $msg = 'Updated successfully.';
        }

        $this->flash->addMessage($type, $msg);

        return $response->withRedirect(
            $this->router->pathFor('setting.sensor')
        );
    }

    public function viewDeviceSetting(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Devices';
        $data['setting'] = $this->userRepository->getDeviceSettingByUserId(
            $userId
        );

        return $this->view->render(
            $response,
            'user/view_device_setting.twig',
            $data
        );
    }

    public function updateDeviceSetting(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data['user_id'] = $request->getAttribute('userId');

        $this->logger->log('Device settings data: ' . json_encode($data));

        $isUpdated = $this->userRepository->updateDeviceSetting($data);
        if ($isUpdated === false) {
            $type = 'error';
            $msg = 'Some problem occurred, please try again.';
        } else {
            $type = 'success';
            $msg = 'Updated successfully.';
        }

        $this->flash->addMessage($type, $msg);

        return $response->withRedirect(
            $this->router->pathFor('setting.device')
        );
    }

    public function viewSensorType(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Sensor Selection';
        $data['sensors'] = $this->apiRepository->getSensorTypeData();
        $data['userSensors'] = $this->userRepository->getUserSensorType(
            $userId
        );

        return $this->view->render(
            $response,
            'user/view_sensor_type.twig',
            $data
        );
    }

    public function updateSensorType(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data['user_id'] = $request->getAttribute('userId');
        $data['is_published'] = 0;
        
        for ($i=1; $i<=8; $i++) {            
            if ($data["sensor{$i}_name"] === '') {
                $data["sensor{$i}_pin"] = '';
                
            }
        }

        $isUpdated = $this->userRepository->updateSensorType($data);
        if ($isUpdated === false) {
            $type = 'error';
            $msg = 'Some problem occurred, please try again.';
        } else {
            $type = 'success';
            $msg = 'Updated successfully.';
        }

        $this->flash->addMessage($type, $msg);

        return $response->withRedirect(
            $this->router->pathFor('setting.sensorType')
        );
    }

    public function viewCode(Request $request, Response $response)
    {
        $data['page']['title'] = 'Sensor Code';
        $data['sensors'] = $this->apiRepository->getSensorTypeData();

        return $this->view->render(
            $response,
            'user/view_code.twig',
            $data
        );
    }
}
