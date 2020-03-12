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

        return $this->render('single_ticket/index.html.twig', [
            'controller_name' => 'SingleTicketController',
            'ticket' => $singleTicket,
            'allComments' => $allComments
        ]);
    }
}
