<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
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

        $currentUserId = $this->getUser()->getId();


        $tickets = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy(['agent_id' => $currentUserId]);

        if (!$tickets) {
            return $this->render('agent_dashboard/index.html.twig', ['product' => 'This is not here']);
        }
        $ticketsArr = [];
        foreach ($tickets AS $ticket){
            array_push($ticketsArr, $ticket);
        }


        return $this->render('agent_dashboard/index.html.twig', ['product' => $ticketsArr[0]->getSubject()]);
    }
    }

