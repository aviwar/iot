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
        $data['page']['title'] = 'Login';
        return $this->view->render($response, 'login.twig', $data);
    }

    public function postLogIn(Request $request, Response $response)
    {
        $redirect = $this->router->pathFor('user.dashboard');

        $validation = $this->validator->validate($request, [
            'username' => Valid::noWhitespace()->notEmpty(),
            'password' => Valid::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $user = $this->authenticator->checkActiveUser(
            $request->getParam('username'),
            $request->getParam('password')
        );

        if (!$user) {
            $this->flash->addMessage('error', 'Invalid username/password.');
            return $response->withRedirect($this->router->pathFor('login'));
        }

        if ($user['is_active'] == '-1') {
            $redirect = $this->router->pathFor('user.changePassword');
        }        

        return $response->withRedirect($redirect);
    }

    public function getLogout(Request $request, Response $response)
    {
        $this->authenticator->logout();
        return $response->withRedirect($this->router->pathFor('login'));
    }

    public function getChangePassword(Request $request, Response $response)
    {
        $data['page']['title'] = 'Change Password';

        return $this->view->render($response, 'user/view_change_password.twig', $data);
    }

    public function postChangePassword(Request $request, Response $response)
    {
        $redirect = $this->router->pathFor('user.changePassword');

        $userId = $request->getAttribute('userId');

        $validation = $this->validator->validate($request, [
            'newPassword' => Valid::noWhitespace()->notEmpty()->length(6, null),
            'cnfNewPassword' => Valid::noWhitespace()->notEmpty()->length(6, null),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($redirect);
        }

        $password = $request->getParam('newPassword');
        $cnfPassword = $request->getParam('cnfNewPassword');

        if ($password !== $cnfPassword) {
            $this->flash->addMessage('error', 'Password and Confirm password should be match!.');
            return $response->withRedirect($redirect);
        }

        $status = $this->authRepository->updateUserPassword($userId, $password);
        if (!$status) {
            $this->flash->addMessage('error', 'Unable to update Password. Please try again later!.');
            
        } else {
            $this->flash->addMessage('success', 'Password Changed!.');
        }
        
        return $response->withRedirect($redirect);
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
