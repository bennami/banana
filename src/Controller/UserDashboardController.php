<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserDashboardController extends AbstractController
{
    /**
     * @Route("/user/dashboard", name="user_dashboard")
     */
//    public function readAllTicket():Response
//    {
//        $entityManager = $this->getDoctrine()->getManager();
//        $ticket = new Ticket();
//        $ticket->setUserId('2');
//        $ticket->setSubject('poopButthole');
//        $ticket->setStatus('open');
//
//        $entityManager->persist($ticket);
//        $entityManager->flush();
//
//        return new Response ($ticket->setSubject($ticket));
//    }

    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        return $this->render('templates/index.html.twig', ['ticket' => $product]);
    }

    public function index()
    {

        return $this->render('user_dashboard/index.html.twig', [
            'controller_name' => 'UserDashboardController',
        ]);
    }

    /**
     * @Route("/ticket/{id}", name="product_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (!$product) {
            return $this->render('manager/index.html.twig', ['product' => 'This is not here']);
        }
        $tickets = [];
        foreach ($product->getTicketCreated() AS $ticket){
            array_push($tickets, $ticket->getSubject());
    }


        return $this->render('manager/index.html.twig', ['product' => $tickets]);
    }
}
