<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AgentDashboardController extends AbstractController
{
    /**
     * @Route("/agent/dashboard", name="agent_dashboard")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('agent_dashboard/index.html.twig', [
            'controller_name' => 'AgentDashboardController',
            'user' => $user
        ]);
    }
}
