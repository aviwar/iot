<?php

namespace Iot\Middleware;

class MaintenanceMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $maintenanceMode = $this->container->get('settings')['maintenanceMode'];
        if ($maintenanceMode) {
            return $this->container->view->render(
                $response,
                'maintenance.twig'
            );
        }

        return $response = $next($request, $response);
    }
}
