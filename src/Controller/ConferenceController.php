<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    /**
     * @Route("/conference/{id}", name="conference")
     * 匹配路由
     */
    public function show(Request $request, Conference $conference, CommentRepository $commentRepository, ConferenceRepository $conferenceRepository):Response
    {
        $offset = max(0,$request->query->getInt('offset',0));
        $paginator = $commentRepository->getCommentPaginator($conference,$offset);

        return new Response($this->twig->render('conference/show.html.twig',[
            'conferences' => $conferenceRepository->findAll(),
            'conference'    => $conference,
            // 'comments'       => $commentRepository->findBy(['conference' =>$conference],['createAt' => 'DESC']),
            'comments'      =>  $paginator,
            'previous'      =>  $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next'          =>  min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
        ]));
    }

    /**
     * @Route("/hello", name="homepage")
     * 匹配路由
     */
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        // $greet = '';
        // if($name) { 
        //     $greet = sprintf('<h1> %u Hello %s!</h1>',100,htmlspecialchars($name)); //sprintf()把百分号（%）符号替换成一个作为参数进行传递的变量。
        // }
        // return new Response(<<<EOF
        // <html>
        //    <body> 
        //    $greet
        //         <img src="/images/under-construction.gif" />
        //     </body>
        // </html>
        // EOF
        // );

        return new Response($this->twig->render('conference/index.html.twig',[
            // 'conferences'   =>  ConferenceRepository->findAll(),
            'conferences' => $conferenceRepository->findAll(),
            // 'conference'    =>  $conference,
        ]));
    }
}