<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ticket;
use App\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket", name="ticket")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */

    public function ticket(Request $request): Response
    {

        $ticket = new Ticket();



        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $ticket->setPriority(5);
            $ticket->setStatus('open');

            $ticket->setDate(new \DateTime());
//            $ticket->setUserId(1);
//            $ticket->setAgentId(1);

            $form->get('subject')->getData();
            //$ticket->setSubject($ticket);
//            $ticket->getSubject();


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();

           return $this->redirectToRoute('user_dashboard');
        }
//        return $this->render('ticket/index.html.twig', [
//            'TicketType' => $form->createView(),
//        ]);
        return $this->render('ticket/index.html.twig', [
            'TicketType' => $form->createView(),
        ]);
    }


//    public function index()
//    {
//        return $this->render('ticket/index.html.twig', [
//            'controller_name' => 'TicketController',
//        ]);
//    }
}
