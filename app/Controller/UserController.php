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
        $data['projectTitle'] = $this->userRepository->getProjectTitleByUserId($userId);

        return $this->view->render($response, 'user/dashboard.twig', $data);
    }

    public function viewProjectTitle(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Update Project Title';
        $data['projectTitle'] = $this->userRepository->getProjectTitleByUserId($userId);

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

        return $response->withRedirect(
            $this->router->pathFor('title')
        );
    }

    public function viewSensorList(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Real Time Sensor Values';
        $data['sensors'] = $this->userRepository->getSensorByUserId($userId);
        $data['setting'] = $this->userRepository->getSensorSettingByUserId($userId);
        $data['setting']['sensor_count'] = ($data['setting']['sensor_count']) ?? 8;

        return $this->view->render($response, 'user/view_sensors.twig', $data);
    }

    public function viewDeviceSwitch(Request $request, Response $response)
    {
        $data['page']['title'] = 'Device On/Off Buttons';

        $userId = $request->getAttribute('userId');
        $data['device'] = $this->userRepository->getDeviceByUserId($userId);
        $data['setting'] = $this->userRepository->getDeviceSettingByUserId($userId);
        $data['setting']['device_count'] = ($data['setting']['device_count']) ?? 6;

        return $this->view->render(
            $response,
            'user/view_device_switch.twig',
            $data
        );
    }

    public function viewDeviceSerialData(Request $request, Response $response)
    {
        $data['page']['title'] = 'Send Serial Data to Device';

        return $this->view->render($response, 'user/view_device_data_form.twig', $data);
    }

    public function viewLocation(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Location Summary';
        $data['locations'] = $this->userRepository->getLocationByUserId($userId);

        return $this->view->render($response, 'user/view_locations.twig', $data);
    }

    public function viewReset(Request $request, Response $response)
    {
        $data['page']['title'] = 'Reset Sensor Data';

        return $this->view->render($response, 'user/view_reset_form.twig', $data);
    }

    public function viewSensorSetting(Request $request, Response $response)
    {
        $userId = $request->getAttribute('userId');

        $data['page']['title'] = 'Sensors';
        $data['setting'] = $this->userRepository->getSensorSettingByUserId($userId);

        return $this->view->render($response, 'user/view_sensor_setting.twig', $data);
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
        $data['setting'] = $this->userRepository->getDeviceSettingByUserId($userId);

        return $this->view->render($response, 'user/view_device_setting.twig', $data);
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
}
