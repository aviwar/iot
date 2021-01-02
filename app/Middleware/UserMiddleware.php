<?php
namespace Iot\Middleware;

class UserMiddleware extends Middleware {
    public function __invoke($request, $response, $next) {
        if ($this->container->authenticator->checkAuth() === false) {
            return $response->withRedirect($this->container->router->pathFor('login'));
        }

        $request = $request->withAttribute('userId', $_SESSION['user_id']);

        $response = $next($request, $response);

        return $response;
    }
}
