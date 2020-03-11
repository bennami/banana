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

        return $this->render('agent_dashboard/index.html.twig', [
            'controller_name' => 'AgentDashboardController',
            'user' => $user
        ]);
    }

    public function getOpenTicket($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['status' => 'Open']);

        if (!$product) {
            return $this->render('agent_dashboard/index.html.twig', ['product' => 'This is not here']);
        }
        $tickets = [];
        foreach ($product->getTicketCreated() AS $ticket){
            array_push($tickets, $ticket->getSubject());
        }


        return $this->render('agent_dashboard/index.html.twig', ['product' => $tickets]);
    }

    public function show($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            return $this->render('agent/index.html.twig', ['product' => 'This is not here']);
        }
        $tickets = [];
        foreach ($user->getTicketCreated() AS $ticket){
            array_push($tickets, $ticket->getSubject());
    }


        return $this->render('agent_dashboard/index.html.twig', ['product' => $tickets]);
    }
}
