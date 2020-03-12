<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ResetPasswordController extends AbstractController
{
    /**
     * @Route("/reset", name="reset")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function reset(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // similar to registration controller

        //instantiate user class
        $user = new User();


        // Get entered email for check
        $userEmail = $request->request->get('reset_password'){'email'};

        //this is better than the above way of fetching email, dont know how to though
        /* $reset = $form->getData();
           $reset['email'];*/


        // create form and handle requests
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            // If email in database, get it and update the password
            $userSelected = $this->getDoctrine()->getRepository(User::class)->findBy(['email' => $userEmail]);
            if ($userSelected) {
                //userSelected is an array, so we use [0]. there's never gonna be more that one user
                $user = $userSelected[0];

                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                //query, insert into  db
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();


                //if you  successfully  change page, redirect to login
                return $this->redirectToRoute('app_login');
            }
            //otherwise, throw error, and tell them to try again
            else {

                echo '<script>alert("Your password or email is incorrect, please try again. If you do not have an account, register first")</script>';
            }

        }

        return $this->render('reset_password/index.html.twig', [
            'ResetPassword' => $form->createView(),
        ]);
    }
}
