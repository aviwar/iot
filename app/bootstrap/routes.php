<?php

use Iot\Middleware\{ApiMiddleware, GuestMiddleware, UserMiddleware};

/* Guest Middleware */
$app
    ->group('', function () use ($app) {
        $app->get('/login', 'authController:getLogIn')->setName('login');
        $app->post('/login', 'authController:postLogIn');
    })
    ->add(new GuestMiddleware($container));

/* User Middleware */
$app
    ->group('', function () use ($app) {
        $app->get('/', 'userController:dashboard')->setName('home');

        $app
            ->get('/sensors', 'userController:viewSensorList')
            ->setName('sensors');

        $app
            ->get('/title', 'userController:viewProjectTitle')
            ->setName('title');
        $app->post('/title', 'userController:updateProjectTitle');

        $app
            ->get('/mobile', 'userController:viewMobileNumber')
            ->setName('mobile');
        $app->post('/mobile', 'userController:updateMobileNumber');

        /* Device */
        $app
            ->get('/device/switch', 'userController:viewDeviceSwitch')
            ->setName('device.switch');
        $app
            ->get('/device/serialData', 'userController:viewDeviceSerialData')
            ->setName('device.serialData');

        $app
            ->get('/locations', 'userController:viewLocation')
            ->setName('locations');

        /* settings */
        $app
            ->get('/settings/sensor', 'userController:viewSensorSetting')
            ->setName('setting.sensor');
        $app->post('/settings/sensor', 'userController:updateSensorSetting');

        $app
            ->get('/settings/device', 'userController:viewDeviceSetting')
            ->setName('setting.device');
        $app->post('/settings/device', 'userController:updateDeviceSetting');

        $app
            ->get('/settings/sensorType', 'userController:viewSensorType')
            ->setName('setting.sensorType');
        $app->post('/settings/sensorType', 'userController:updateSensorType');

        $app->get('/reset', 'userController:viewReset')->setName('reset');

        $app->get('/logout', 'authController:getLogout')->setName('logout');
    })
    ->add(new UserMiddleware($container));

/* API Middleware */
$app
    ->group('/api', function () use ($app) {
        $app
            ->get('/sensors[/{date}]', 'apiController:getSensorData')
            ->setName('api.getSensors');
        $app->post('/sensors', 'apiController:postSensorData');

        $app->get('/devices', 'apiController:getDeviceData');
        $app
            ->post('/devices', 'apiController:updateDeviceStatus')
            ->setName('api.updateDeviceStatus');

        $app->get('/devices/serialData', 'apiController:getDeviceSerialData');
        $app
            ->post('/devices/serialData', 'apiController:postDeviceSerialData')
            ->setName('api.sendDeviceSerialData');

        $app
            ->get('/locations[/{date}]', 'apiController:getLocationData')
            ->setName('api.getLocations');
        $app->post('/locations', 'apiController:postLocationData');

        $app
            ->delete('/reset', 'apiController:postResetData')
            ->setName('api.resetData');

        $app->get('/sensorType', 'apiController:getSensorTypeData');
    })
    ->add(new ApiMiddleware($container));

// Authorize user for mobile app
$app->post('/api/auth/user', 'authController:authorizeUser');
