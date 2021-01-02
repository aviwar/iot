<?php
namespace Iot\Util;
use Delight\Random\Random;

class Authenticator
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function checkAuth()
    {
        $userId = $this->getUserId();
        $uniqId = $this->getUserAuthToken();
        return $this->container->authRepository->checkAuthenticateUser(
            $userId,
            $uniqId
        );
    }

    public function getUserName()
    {
        return isset($_SESSION['username']) ? $_SESSION['username'] : '';
    }

    public function getUserId()
    {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    }

    // public function getUserEmail() {
    //     return (isset($_SESSION['email'])?$_SESSION['email']:'');
    // }

    // public function getUserRole() {
    //     return (isset($_SESSION['role'])?$_SESSION['role']:'');
    // }

    // public function getUserEnrolled() {
    //     return (isset($_SESSION['isUserEnrolled'])?$_SESSION['isUserEnrolled']:false);
    // }

    public function getUserAuthToken()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : '';
    }

    public function checkUserByUsername($username, $password)
    {
        $user = $this->container->authRepository->getUser($username, $password);
        if (empty($user) === true) {
            return false;
        }

        $this->setUserSessionData($user);

        return true;
    }

    public function setUserSessionData($user)
    {
        $userId = $user['user_id'];
        $uniqId = $this->getRandomString(32);
        $this->container->authRepository->updateUserAuthToken($userId, $uniqId);

        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $user['username'];
        // $_SESSION['role'] = $user['role'];
        // $_SESSION['email'] = $user['email'];
        $_SESSION['token'] = $uniqId;
    }

    public function logout()
    {
        // reset uniqId for user
        $userId = $this->getUserId();
        $uniqId = '';
        $this->container->authRepository->updateUserAuthToken($userId, $uniqId);
        session_destroy();
    }

    public function getRandomString($length = 16)
    {
        return Random::alphaHumanString($length);
    }

    public function getOTP()
    {
        return Random::intBetween(100000, 999999);
    }
}
