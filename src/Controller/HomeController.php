<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home/{jk}", name="home")
     */
    public function index(string $jk): Response
    {
        $number = 123;
        return new Response("Sault $number + $jk");
    }
    /**
     * @Route("/say/{name}",name="say")
     */
    public function say(string $name) 
    {
        return new Response("Hello $name");
    }
}
