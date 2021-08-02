<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleVoteController extends AbstractController
{
    /**
     * @Route("/article/vote", name="article_vote")
     */
    public function index(): Response
    {
        return $this->render('article_vote/index.html.twig', [
            'controller_name' => 'ArticleVoteController',
        ]);
    }
}
