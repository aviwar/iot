<?php

use Iot\Middleware\{
    ApiMiddleware, GuestMiddleware, UserMiddleware
};

/* Guest Middleware */
$app->group('', function() use ($app) {
    $app->get('/login', 'authController:getLogIn')->setName('login');
    $app->post('/login', 'authController:postLogIn');
})->add(new GuestMiddleware($container));

/* User Middleware */
$app->group('', function() use ($app) {
    $app->get('/', 'userController:dashboard')->setName('home');

    $app->get('/sensors', 'userController:viewSensorList')->setName('sensors');

    /* Device */
    $app->get('/device/switch', 'userController:viewDeviceSwitch')->setName('device.switch');
    $app->get('/device/serialData', 'userController:viewDeviceSerialData')->setName('device.serialData');


    /* settings */
    $app->get('/settings/sensorcount', 'userController:viewSensorCount')->setName('setting.sensorcount');

    $app->get('/reset', 'userController:viewReset')->setName('reset');

    $app->get('/logout', 'authController:getLogout')->setName('logout');
})->add(new UserMiddleware($container));

/* API Middleware */
$app->group('/api', function() use ($app) {
    $app->get('/sensors[/{date}]', 'apiController:getSensorData')->setName('api.getSensors');
    $app->post('/sensors', 'apiController:postSensorData');

    $app->get('/devices', 'apiController:getDeviceData');
    $app->post('/devices', 'apiController:updateDeviceStatus')->setName('api.updateDeviceStatus');

    $app->get('/devices/serialData', 'apiController:getDeviceSerialData');
    $app->post('/devices/serialData', 'apiController:postDeviceSerialData')->setName('api.sendDeviceSerialData');

    $app->delete('/reset', 'apiController:postResetData')->setName('api.resetData');

})->add(new ApiMiddleware($container));
