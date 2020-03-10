<?php

namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserDashboardController extends AbstractController
{
    /**
     * @Route("/user/dashboard", name="user_dashboard")
     */
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
            ->getRepository(Ticket::class)
            ->find($id);

        if (!$product) {
            return $this->render('manager/index.html.twig', ['product' => 'This is not here']);

        }


        return $this->render('manager/index.html.twig', ['product' => $product]);
    }
}
