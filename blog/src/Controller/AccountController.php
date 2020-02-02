<?php

namespace App\Controller;

class AccountController
{
    public function index()
    {
       return $this->render('account/account.html.twig', []);
    }
}