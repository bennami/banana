<?php

namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AgentDashboardController extends AbstractController
{
    /**
     * @Route("/agent/dashboard", name="agent_dashboard")
     */
    public function index()
    {
        $userId = $this->getUser()->getId();

        $ticket = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy(['agent_id' => $userId]);

        if (!$ticket) {
            throw $this->createNotFoundException(
                'No product found for id '.$userId
            );
        }
        $ticketArray = [];
        foreach ($ticket AS $tickett){
            array_push($ticketArray, $tickett);
        }


        return $this->render('agent_dashboard/index.html.twig', [
            'controller_name' => 'AgentDashboardController',
            'user' => $ticketArray
        ]);
    }
}
