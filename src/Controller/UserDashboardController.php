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
    public function index()
    {

        $allTickets = $this->getDoctrine()->getRepository(Ticket::class)
            ->findBy(['user_id' => $this->getUser()->getId()]);

        if (!$allTickets) {
            return $this->render('user_dashboard/index.html.twig',
                ['tickets' => 'No ticket found']);

        }
        return $this->render('user_dashboard/index.html.twig',
        ['tickets' => $allTickets]);
    }

    public function createProduct()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $ticket = new Ticket();
//        $ticket->setSubject('Keyboard');
//        $ticket->setStatus('in progression');
//        $ticket->setPriority('Ergonomic and stylish!');
//        $ticket->setDate(new \DateTime());
//        //$ticket->setDate('2020-03-10 16:06:14');
//
//        // tell Doctrine you want to (eventually) save the Product (no queries yet)
//        $entityManager->persist($ticket);
//
//        // actually executes the queries (i.e. the INSERT query)
//        $entityManager->flush();

        //return new Response('Saved new product with id '.$ticket->getStatus());
        return $this->render('user_dashboard/index.html.twig' /*['product' => $ticket]*/);
    }
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

//    public function show($id)
//    {
//        $product = $this->getDoctrine()
//            ->getRepository(Ticket::class)
//            ->find($id);
//
//        if (!$product) {
//            throw $this->createNotFoundException(
//                'No product found for id ' . $id
//            );
//        }
//        return $this->render('templates/index.html.twig', ['ticket' => $product]);
//    }
//
//    public function index()
//    {
//
//        return $this->render('user_dashboard/index.html.twig', [
//            'controller_name' => 'UserDashboardController',
//        ]);
//    }

    /**
     * @Route("/ticket/{id}", name="product_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */

//    public function show($id)
//    {
//        $user = $this->getDoctrine()
//            ->getRepository(User::class)
//            ->find($id);
//
//        if (!$user) {
//            return $this->render('manager/index.html.twig', ['product' => 'This is not here']);
//        }
//        $tickets = [];
//        foreach ($user->getTicketCreated() AS $ticket){
//            array_push($tickets, $ticket->getSubject());
//    }
//
//
//        return $this->render('user_dashboard/index.html.twig', ['product' => $tickets]);
//    }

//    public function show($id)
//    {
//        $product = $this->getDoctrine()
//            ->getRepository(User::class)
//            ->find($id);
//
//        if (!$product) {
//            return $this->render('user_dashboard/index.html.twig', ['product' => 'This is not here']);
//        }
//        $tickets = [];
//        foreach ($product->getTicketCreated() AS $ticket){
//            array_push($tickets, $ticket->getSubject());
//    }
//
//
//        return $this->render('user_dashboard/index.html.twig', ['product' => $tickets]);
//    }


        //return $this->render('user_dashboard/index.html.twig', ['product' => $product->getUsername()]);


}
