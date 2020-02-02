<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends AbstractController
{
    public function allPosts ()
    {
        return new Response(
            '<html><body>Hello World!</body></html>'
        );
    }
}