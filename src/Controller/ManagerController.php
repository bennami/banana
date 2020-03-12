<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Form\EditTicketType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ManagerController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        //$ticket = new Ticket();
        $form = $this->createForm(EditTicketType::class );
        $form->handleRequest($request);

       /*  if ($this->getUser()){
            if ($this->getUser()->getRoles() == ["ROLE_ADMIN"]){
                $status = $form->get('status')->getData();
                $ticket->setStatus($status);
            }
        } else {

        }*/

        // Checking for user is admin
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if (!$hasAccess){
            return $this->forward('App\Controller\ErrorController::index', [
                'controller_name' => 'ErrorController',
                'username' => $this->getUser()->getUsername()
            ]);
        }

        //Gathering agent name per ticket

        //getting all tickets and push in array
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

        return $this->render('manager/index.html.twig', [
            'numberOfTimes' => count($allTickets),
            'allTickets' => $allTickets,
            'username' => $this->getUser()->getUsername(),
            'agentName' => $agentsAssigned,
            'EditTicket' => $form->createView(),
        ]);
    }

}
