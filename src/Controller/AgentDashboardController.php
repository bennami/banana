<?php

namespace App\Controller;

use App\Entity\Ticket;

use App\Entity\User;

use App\Form\AssignToMeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AgentDashboardController extends AbstractController
{
    /**
     * @Route("/agent/dashboard", name="agent_dashboard")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {

        $username = $this->getUser()->getUsername();
        $user = $this->getDoctrine()->getRepository(User::class)
            ->findBy(['username' => $username]);


        $userId = $this->getUser()->getId();
        $ticket = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy(['agent_id' => $userId]);

        if (!$ticket) {
            return $this->render('agent_dashboard/index.html.twig',
                ['subject' => 'this is not available',
                    'username' => $username,
                    'ticket' => $this->getUser()]);
        }
        $ticketArray = [];
        foreach ($ticket AS $tickett) {
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
        foreach ($tickets AS $ticket) {
            array_push($ticketsArr, $ticket);
        }


        $openTickets = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy(['status' => 'Open']);
        $form = $this->createForm(AssignToMeType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }


            return $this->render('agent_dashboard/index.html.twig', [
            'subject' => $ticketsArr[0]->getSubject(),
            'ticketsAssignedToMe' => $tickets,
            'username' => $username,
            'id' => $this->getUser()->getId(),
            'openTickets' => $openTickets]);

    }


}

