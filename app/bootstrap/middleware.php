<?php

$app->add(new \Iot\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \Iot\Middleware\OldInputMiddleware($container));
$app->add(new \Iot\Middleware\MaintenanceMiddleware($container));
