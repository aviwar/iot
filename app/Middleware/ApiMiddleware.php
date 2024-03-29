<?php

namespace Iot\Middleware;

class ApiMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $username = $request->getHeaderLine('username');
        if (empty($username)) {
            throw new \Exception('Invalid username', 400);
        }

        $user = $this->container->authRepository->getUserByUsername($username);
        if (empty($user)) {
            throw new \Exception('User not found!', 404);
        }

        $request = $request->withAttribute('userName', $user['username']);
        $request = $request->withAttribute('userId', $user['user_id']);
        $request = $request->withAttribute('mobileNumber', $user['mobile']);

        $response = $next($request, $response);

        return $response;
    }
}
