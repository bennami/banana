<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SingleTicketController extends AbstractController
{
    /**
     * @Route("/ticket/{id}", name="single_ticket")
     */

    public function index($id)
    {

        $singleTicket = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findOneBy(['id'=> $id]);

        $allComments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(['ticket_id'=> $singleTicket->getId()]);

        $allTickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
        $agentsAssignedID = [];
        foreach ($allTickets as $ticket){
            array_push($agentsAssignedID, $ticket->getAgentId());
        }
        $agentsAssigned = [];
        foreach ($agentsAssignedID as $agentId){
            $agent = $this->getDoctrine()
                ->getRepository(User::class)

                //find agent id that matches  ticket id and push  it to array
                ->findOneBy(['id' => $agentId]);
            array_push($agentsAssigned, $agent->getUsername());
        }

        return $this->render('single_ticket/index.html.twig', [
            'controller_name' => 'SingleTicketController',
            'ticket' => $singleTicket,
            'allComments' => $allComments,
            'agentName' => $agentsAssigned,

        ]);
    }
}
