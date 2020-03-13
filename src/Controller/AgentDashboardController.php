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
    public function index(){

        $username = $this->getUser()->getUsername();
        $user = $this->getDoctrine()->getRepository(User::class)
            ->findBy(['username' => $username]);


        $userId = $this->getUser()->getId();
        $ticket = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy(['agent_id' => $userId]);

        if (!$ticket) {
            throw $this->createNotFoundException(
                'No tickets found for id'.$userId
            );
        }
        $ticketArray = [];
        foreach ($ticket AS $tickett){
            array_push($ticketArray, $tickett);
        }

        //$ticketStatus = $ticket->getStatus();

        $currentUserId = $this->getUser()->getId();


        $tickets = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy(['agent_id' => $currentUserId]);

        if (!$user) {
            return $this->render('agent_dashboard/index.html.twig', ['user' => 'And who tf are YOU?']);
        }
        $ticketsArr = [];
        foreach ($tickets AS $ticket){
            array_push($ticketsArr, $ticket);
        }


        return $this->render('agent_dashboard/index.html.twig', ['subject' => $ticketsArr[0]->getSubject(), 'username' => $username, 'id' => $this->getUser()->getId()]);
     }


    }

