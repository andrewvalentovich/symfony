<?php



namespace App\Controller;
use App\Homework\ArticleProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;



class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="app_article_page")
     */
    public function article_page(Environment $twig, ArticleProvider $articleProvider, $id)
    {
        return $this->render('article/article.html.twig', [
            'article'       =>      $articleProvider->article(),
        ]);
    }
}