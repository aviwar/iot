<?php
namespace Iot\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends BaseController
{
    public function dashboard(Request $request, Response $response)
    {
        $data['page']['title'] = 'Home';

        return $this->view->render($response, 'user/dashboard.twig', $data);
    }

    public function viewSensorList(Request $request, Response $response)
    {
        $data['page']['title'] = 'Real Time Sensor Values';

        $userId = $request->getAttribute('userId');
        $data['sensors'] = $this->userRepository->getSensorByUserId($userId);

        return $this->view->render($response, 'user/view_sensors.twig', $data);
    }

    public function viewDeviceSwitch(Request $request, Response $response)
    {
        $data['page']['title'] = 'Device On/Off Buttons';

        $userId = $request->getAttribute('userId');
        $data['device'] = $this->userRepository->getDeviceByUserId($userId);
        $data['deviceCount'] = 6;

        return $this->view->render(
            $response,
            'user/view_device_switch.twig',
            $data
        );
    }

    public function viewDeviceSerialData(Request $request, Response $response)
    {
        $data['page']['title'] = 'Send Serial Data to Device';

        // $userId = $request->getAttribute('userId');

        // $data['sensors'] = $this->userRepository->getSensorByUserId($userId);

        return $this->view->render($response, 'user/view_sensors.twig', $data);
    }
}
