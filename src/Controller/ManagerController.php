<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ManagerController extends AbstractController
{
    /**
     * @Route("/manager", name="manager")
     */
    public function index()
    {


        // Checking for user role
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if (!$hasAccess){
            return $this->forward('App\Controller\ErrorController::index', [
                'controller_name' => 'ErrorController',
                'username' => $this->getUser()->getUsername()
            ]);
        }


        //Gathering agent name per ticket
        $allTickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
        $agentsAssignedID = [];
        foreach ($allTickets as $ticket){
            array_push($agentsAssignedID, $ticket->getAgentId());
        }
        $agentsAssigned = [];
        foreach ($agentsAssignedID as $agentId){
            $agent = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['id' => $agentId]);
            array_push($agentsAssigned, $agent->getUsername());
        }



        return $this->render('manager/index.html.twig', [
            'numberOfTimes' => count($allTickets),
            'allTickets' => $allTickets,
            'username' => $this->getUser()->getUsername(),
            'agentName' => $agentsAssigned
        ]);
    }

}
