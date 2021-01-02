<?php

namespace Iot\Middleware;

class GuestMiddleware extends Middleware {
    public function __invoke($request, $response, $next) {
        if ($this->container->authenticator->checkAuth() === true) {
            return $response->withRedirect(
                $this->container->router->pathFor('home')
            );
        }

        $response = $next($request, $response);

        return $response;
    }
}
