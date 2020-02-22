<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends AbstractController
{
    public function index(Request $request)
    {
        return $this->render('homepage/homepage.html.twig');
    }
}