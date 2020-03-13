<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index()
    {

        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $isAgent = $this->isGranted('ROLE_FIRST_LINE');
        $isAgent2 = $this->isGranted('ROLE_SECOND_LINE');
        $isCustomer = $this->isGranted('ROLE_CUSTOMER');



        if ($isAdmin) {
            return $this->redirectToRoute('managerDashboard');
        } elseif ($isAgent || $isAgent2) {
            return $this->redirectToRoute('agentDashboard');
        } else {
            return $this->redirectToRoute('userDashboard');
        }
    }
}
