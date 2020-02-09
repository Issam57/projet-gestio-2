<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdminController extends AbstractController
{
    /**
     * @Route("/login/admin", name="account_login_admin")
     */
    public function login()
    {
        return $this->render('account_admin/login_admin.html.twig');
    }
}
