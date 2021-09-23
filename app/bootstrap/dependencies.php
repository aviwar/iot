<?php

use Iot\Controller\{ApiController, AuthController, UiController, UserController};
use Iot\Repository\{ApiRepository, AuthRepository, UserRepository};
use Iot\Util\{Authenticator, Config, Db, Logger, Sms, Validator};

$container = $app->getContainer();

$container['authenticator'] = function ($container) {
    return new Authenticator($container);
};

$container['config'] = function ($container) {
    $settings = $container->get('settings');
    return new Config($settings);
};

$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages();
};

$container['view'] = function ($container) {
    $cf = $container->get('settings')['view'];
    $view = new \Slim\Views\Twig($cf['path'], $cf['twig']);
    $view->addExtension(
        new \Slim\Views\TwigExtension(
            $container->router,
            $container->request->getUri()
        )
    );

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container['authenticator']->checkAuth(),
        'userName' => $container['authenticator']->getUserName(),
        'userId' => $container['authenticator']->getUserId(),
    ]);

    $view->getEnvironment()->addGlobal('sideMenu', $container['authenticator']->getSideMenu());
    $view->getEnvironment()->addGlobal('customUI', $container->get('settings')['custom_ui']);

    $view
        ->getEnvironment()
        ->addGlobal('appName', $container->get('settings')['app_name']);
        
    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};

$container['db'] = function ($container) {
    $settings = $container->get('settings')['db'];
    return new Db(
        $settings['host'],
        $settings['user'],
        $settings['password'],
        $settings['name']
    );
};

$container['apiController'] = function ($container) {
    return new ApiController($container);
};

$container['authController'] = function ($container) {
    return new AuthController($container);
};

$container['uiController'] = function ($container) {
    return new UiController($container);
};

$container['userController'] = function ($container) {
    return new UserController($container);
};

$container['apiRepository'] = function ($container) {
    return new ApiRepository($container->get('db'));
};

$container['authRepository'] = function ($container) {
    return new AuthRepository($container->get('db'));
};

$container['userRepository'] = function ($container) {
    return new UserRepository($container->get('db'));
};

$container['logger'] = function ($container) {
    return new Logger($container->get('config'));
};

$container['sms'] = function ($container) {
    $settings = $container->get('settings')['sms'];
    return new Sms(
        $settings['clientId'],
        $settings['apiKey'],
        $settings['senderId']
    );
};

$container['validator'] = function ($container) {
    return new Validator();
};

$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        $errorMessage = $exception->getMessage();
        $errorCode = !empty($exception->getCode())
            ? $exception->getCode()
            : 500;
        $logger = $container->get('logger');
        $logger->log($errorMessage);
        $data = [
            'status' => 'error',
            'message' => $errorMessage,
        ];
        $body = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return $container['response']
            ->withStatus($errorCode)
            ->withHeader('Content-type', 'application/json')
            ->write($body);
    };
};

$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['view']->render(
            $response->withStatus(404),
            '404.twig'
        );
    };
};
