<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/hello/{name}", name="homepage")
     */
    public function index(string $name =''): Response
    {
        $greet = '';
        if($name) { 
            $greet = sprintf('<h1> %u Hello %s!</h1>',100,htmlspecialchars($name)); //sprintf()把百分号（%）符号替换成一个作为参数进行传递的变量。
        }
        return new Response(<<<EOF
        <html>
           <body> 
           $greet
                <img src="/images/under-construction.gif" />
            </body>
        </html>
        EOF
        );
    }
}