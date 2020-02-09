<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\AccountType;
use App\Form\RegistrationClientType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountClientController extends AbstractController
{
    /**
     * Permet d'afficher et de gérer le formulaire de connexion
     *
     * @Route("/login/client", name="account_login_client")
     *
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account_client/login_client.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     *
     * @Route("/logout/client", name="account_logout_client")
     *
     */
    public function logout() {}


    /**
     * Permet d'afficher le formulaire d'inscription
     *
     * @Route("/register/client", name="account_register_client")
     *
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {
        $client = new Client();

        $form =  $this->createForm(RegistrationClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($client, $client->getHash());
            $client->setHash($hash);

            $manager->persist($client);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été crée, veuillez vous connecter svp !"
            );

            return $this->redirectToRoute('account_login_client');
        }

        return $this->render('account_client/registration_client.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     *
     * @Route("/account/profile", name="account_client_profile")
     *
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $manager) {
        $client = $this->getUser();

        $form = $this->createForm(AccountType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                "Les données du profil ont été modifiée avec succès"
            );
        }

        return $this->render('account_client/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
