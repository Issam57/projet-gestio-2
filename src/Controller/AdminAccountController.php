<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\AdminRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_account_login")
     *
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('admin/account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);

    }

    /**
     * @Route("/admin/logout", name="admin_account_logout")
     */
    public function logout() {}


    /**
     * @Route("/admin/register", name="admin_account_register")
     *
     *
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {
        $restaurant = new Restaurant();

        $form = $this->createForm(AdminRegistrationType::class, $restaurant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($restaurant, $restaurant->getHash());
            $restaurant->setHash($hash);

            $manager->persist($restaurant);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été crée, veuillez vous connecter svp !"
            );

            return $this->redirectToRoute('admin_account_login');
        }

        return $this->render('admin/account/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
