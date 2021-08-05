<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Homework\ArticleContentProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesCreateController extends AbstractController
{
    /**
     * @Route("/admin/articles/create/", name="app_admin_articles_create")
     */
    public function articlesCreate(ArticleContentProvider $articleContentProvider, EntityManagerInterface $em)
    {
        $wordArray = ['статья', 'новость', 'ИТ', 'технологии', 'инженерия', 'роботы', 'производство', 'хакинг'];

        $word = (rand(0, 10) <= 7) ? $wordArray[rand(0, 7)] : null;

        $contentText = $articleContentProvider->get(rand(2, 10), $word, rand(2, 12));

        if (strlen($contentText) >= 990) {
            $contentText = substr($contentText, 0, stripos($contentText, ' ', 990));
        }


        $triple = rand(0, 2);

        $titleArray = [
            'Три предметно-ориентированных языка программирования для цифровой обработки сигналов',
            'Как составить ТЗ, чтобы не пришлось икать?',
            'Как создать 3d игру прямо в браузере'
        ];

        $slugArray = [
            'Tri predmetno-oriyentirovannykh yazyka programmirovaniya dlya tsifrovoy obrabotki signalov',
            'Kak sostavit TZ. chtoby ne prishlos ikat?',
            'Kak sozdat 3d igru pryamo v brauzere'
        ];

        $authorArray = [
            'Владимир Петрушкин',
            'Александр Правильный',
            'Петр Создатель'
        ];

        $filenameArray = [
            'article-1.jpeg',
            'article-2.jpeg',
            'article-3.jpg'
        ];


        $article = new Article();

        $article
            ->setTitle($titleArray[$triple])
            ->setSlug(sprintf('%s-%d', $slugArray[$triple], rand(0, 99999)))
            ->setDescription(str_replace('&emsp;', '', substr($contentText, 0, stripos($contentText, ' ', 80))))
            ->setBody($contentText)
            ->setAuthor($authorArray[$triple])
            ->setKeywords(sprintf('%s, %s, %s', $wordArray[rand(0, 7)], $wordArray[rand(0, 7)], $wordArray[rand(0, 7)]))
            ->setVoteCount(rand(-200, 200))
            ->setImageFilename(sprintf('images/%s', $filenameArray[$triple]))
            ->setPublishedAt(new \DateTime(sprintf('-%d days', rand(2, 60))));

        $em->persist($article);
        $em->flush();

        return $this->render('admin/articles_create/index.html.twig', [
            'article' => $article,
        ]);
    }
}
