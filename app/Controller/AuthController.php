<?php
namespace Iot\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as Valid;
use \Exception;

class AuthController extends BaseController
{
    public function getLogIn(Request $request, Response $response)
    {
        return $this->view->render($response, 'login.twig');
    }

    public function postLogIn(Request $request, Response $response)
    {
        $validation = $this->validator->validate($request, [
            'username' => Valid::noWhitespace()->notEmpty(),
            'password' => Valid::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $auth = $this->authenticator->checkUserByUsername(
            $request->getParam('username'),
            $request->getParam('password')
        );

        if (!$auth) {
            $this->flash->addMessage('error', 'Invalid username/password.');
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $redirect = $this->router->pathFor('home');

        return $response->withRedirect($redirect);
    }

    public function getLogout(Request $request, Response $response)
    {
        $this->authenticator->logout();
        return $response->withRedirect($this->router->pathFor('login'));
    }

    public function authorizeUser(Request $request, Response $response)
    {
        $username = $request->getParam('username');
        $password = $request->getParam('password');

        if (empty($username) || empty($password)) {
            throw new \Exception('Invalid credentials', 401);
        }

        $user = $this->container->authRepository->getUser($username, $password);
        if (empty($user)) {
            throw new \Exception('Invalid credentials', 401);
        }

        $responseData['status'] = 'success';
        $responseData['data'] = $user;

        return $response->withJson($responseData, 200);
    }
}
