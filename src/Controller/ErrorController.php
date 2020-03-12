<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function index()
    {
        return $this->render('error/index.html.twig', [
            'controller_name' => 'ErrorController',
            'username' => $this->getUser()->getUsername(),
            'role' => $this->getUser()->getRoles()[0]
        ]);
    }
}
