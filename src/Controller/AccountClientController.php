<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\PasswordUpdate;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
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

        //Permet d'ajouter un client
        $client = new Client();

        $form =  $this->createForm(RegistrationClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Pour encoder le mot de passe
            $hash = $encoder->encodePassword($client, $client->getHash());
            $client->setHash($hash);

            $manager->persist($client);
            $manager->flush();

        //Message flash pour confirmer l'inscription

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
     * @Route("/account/client/profile", name="account_client_profile")
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

    /**
     * Permet de modifier le mot de passe
     *
     * @Route("/account/client/password-update", name="account_client_password")
     *
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager) {
        $passwordUpdate = new PasswordUpdate();

        $client = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $passwordUpdate->getOldPassword();
            $newPassword = $passwordUpdate->getNewPassword();
            //Vérifier que le oldPassword du formulaire est le même que le mot de passe Client
            if(!password_verify($passwordUpdate->getOldPassword(), $client->getHash())) {
                //Gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe tapé n'est pas votre mot de passe actuel"));
                } elseif ($oldPassword === $newPassword) {
                    $form->get('oldPassword')->addError(new FormError("Vous avez saisi le même mot de passe que l'ancien, veuillez en choisir un nouveau"));

            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($client, $newPassword);

                $client->setHash($hash);

                $manager->persist($client);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié"
                );

                return $this->redirectToRoute('accueil_client');
            }
        }

    return $this->render('account_client/password.html.twig', [
        'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le profil de l'utilisateur
     *
     * @Route("/account", name="account_index")
     *
     * @return Response
     */
    public function myAccount() {
        return $this->render('client/index.html.twig', [
            'client' => $this->getUser()
        ]);
    }
}
