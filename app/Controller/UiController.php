<?php

namespace Iot\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UiController extends BaseController
{
    public function landingPage(Request $request, Response $response)
    {
        $customUI = $this->config->getCustomUI();
        $data['page']['title'] = 'Home';

        return $this->view->render($response, $customUI . '/home.twig', $data);
    }

    public function learningBoardPage(Request $request, Response $response)
    {
        $customUI = $this->config->getCustomUI();
        $data['page']['title'] = 'IOT Learning Board';

        return $this->view->render($response, $customUI . '/learning_board.twig', $data);
    }

    public function aboutPage(Request $request, Response $response)
    {
        $customUI = $this->config->getCustomUI();
        $data['page']['title'] = 'About us';

        return $this->view->render($response, $customUI . '/about.twig', $data);
    }

    public function contactPage(Request $request, Response $response)
    {
        $customUI = $this->config->getCustomUI();
        $data['page']['title'] = 'Contact us';

        return $this->view->render($response, $customUI . '/contact.twig', $data);
    }
}
