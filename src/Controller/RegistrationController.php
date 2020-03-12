<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ticket;
use App\Entity\Comment;

use App\Form\RegistrationFormType;
use App\Security\Authenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param Authenticator $authenticator
     * @param array $options
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, Authenticator $authenticator): Response
    {



        $user = new User();
        if (!$this->getUser()){
            $user_roles = ["ROLE_CUSTOMER"];
        } else {
            $user_roles = $this->getUser()->getRoles();

        }

        $form = $this->createForm(RegistrationFormType::class, $user, array('role' => $user_roles));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );



            //getting roles to work babyyy

            if ($this->getUser()){
                if ($this->getUser()->getRoles() == ["ROLE_ADMIN"]){
                    $role = $form->get('roles');
                    $user->setRoles([$role->getData()]);
                    $user->getRoles();
                }
            } else {
                $user->setRoles(["ROLE_CUSTOMER"]);
                $user->getRoles();
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'RegistrationForm' => $form->createView(),

        ]);
    }
}
