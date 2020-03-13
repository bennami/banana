<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ticket;
use App\Entity\User;
use App\Form\AssignToMeType;
use App\Form\CommentOnTicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SingleTicketController extends AbstractController
{
    /**
     * @Route("/ticket/{id}", name="single_ticket")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */

    public function index($id, Request $request)
    {
        $comment = new Comment;
        $form = $this->createForm(CommentOnTicketType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentTicket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['id'=>$id]);

             $comment->setContent($form->get('content')->getData());
             $comment->setTimestamp(new \DateTime());
             $comment->setType('public');
             $comment->setTicketId($currentTicket);
             $comment->setCommentedBy($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }

            $singleTicket = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findOneBy(['id' => $id]);

        $allComments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(['ticket_id' => $singleTicket->getId()]);

        //getting username from User entity to show the USERNAME itself and not an ID
        $allTickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
        $currentTicket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['id'=>$id]);
        $assignedAgent = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$currentTicket->getAgentId()]);
        $assignedAgent->getUsername();


        $assignForm = $this->createForm(AssignToMeType::class);
        $assignForm->handleRequest($request);
        if ($assignForm->isSubmitted() && $assignForm->isValid()) {
            $currentTicket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['id'=>$id]);
            $currentTicket->setAgentId($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentTicket);
            $entityManager->flush();
        }



        return $this->render('single_ticket/index.html.twig', [
            'controller_name' => 'SingleTicketController',
            'numberOfTimes' => count($allTickets),
            'ticket' => $singleTicket,
            'allComments' => $allComments,
            'agentUsername' =>$assignedAgent->getUsername(),
            'form' => $form->createView(),
            'assignForm' => $assignForm->createView()

        ]);
    }
}
