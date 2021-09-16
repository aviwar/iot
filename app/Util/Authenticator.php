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

    public function getUserAuthToken()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : '';
    }

    public function checkActiveUser($username, $password)
    {
        $user = $this->container->authRepository->getActiveUser($username, $password);
        if (empty($user) === true) {
            return false;
        }

        $this->setUserSessionData($user);

        return $user;
    }

    public function setUserSessionData($user)
    {
        $userId = $user['user_id'];
        $uniqId = $this->getRandomString(32);
        $this->container->authRepository->updateUserAuthToken($userId, $uniqId);

        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $user['username'];
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

    public function getSideMenu(){
        $sideMenu = [];
        $currentUrl = $_SERVER['REQUEST_URI'];

        $menuItems = $this->container->userRepository->getMenuItems();
        foreach($menuItems as $key=>$item) {            
            
            list($isActivePage, $subMenu) = $this->processSubMenuItems(
                $this->container->userRepository->getSubMenuItems($item['menu_id']),
                $currentUrl
            );            
            
            $menuURL = '#';
            if (empty($subMenu)) {
                $menuURL = $this->container->router->pathFor($item['menu_url']);
            }
            
            $isActivePage = ($currentUrl === $menuURL) ? true : $isActivePage;

            $sideMenu[$key] = $item;
            $sideMenu[$key]['menu_url'] = $menuURL;
            $sideMenu[$key]['subMenu'] = $subMenu;
            $sideMenu[$key]['isActivePage'] = $isActivePage;

        }
        
        return $sideMenu;
    }

    private function processSubMenuItems($subMenuItems, $currentUrl) {
        $subMenu = [];
        $isActiveMenu = false;

        foreach($subMenuItems as $key=>$item) {
            $isActivePage = false;
            $subMenu[$key] = $item;

            $subMenuURL = $this->container->router->pathFor($item['submenu_url']);

            if ($currentUrl === $subMenuURL) {
                $isActivePage = true;
                $isActiveMenu = true;
            }
            
            $subMenu[$key]['submenu_url'] = $subMenuURL;
            $subMenu[$key]['isActivePage'] = $isActivePage;
        }

        return [
            $isActiveMenu,
            $subMenu,
        ];

    }
}
