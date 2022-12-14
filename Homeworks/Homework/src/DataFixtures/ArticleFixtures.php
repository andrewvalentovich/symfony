<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Entity\User;
use App\Homework\ArticleContentProvider;
use App\Homework\CommentContentProvider;
use App\Service\FileUploader;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;

class ArticleFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private static $articleTitles = [
        'Есть ли жизнь после девятой жизни?',
        'Когда в машинах поставят лоток?',
        'В погоне за красной точкой',
        'В чем смысл жизни сосисок',
    ];

    private static $articleImages = [
        'article-1.jpeg',
        'article-2.jpeg',
        'article-3.jpg',
    ];

    /**
     * @var FileUploader
     */
    private $articleFileUploader;

    /**
     * ArticleFixtures constructor.
     */
    private $commentContentProvider;
    private $articleContentProvider;

    public function __construct(
        CommentContentProvider $commentContentProvider,
        ArticleContentProvider $articleContentProvider,
        FileUploader $articleFileUploader
    )
    {
        $this->commentContentProvider = $commentContentProvider;
        $this->articleContentProvider = $articleContentProvider;
        $this->articleFileUploader = $articleFileUploader;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 25, function($article) use ($manager) {
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setDescription($this->faker->realText(100, 1))
                ->setBody($this->generateContent())
                ->setKeywords($this->generateKeywords($this->faker->numberBetween(1, 4)));

            if ($this->faker->boolean(60)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $fileName = $this->faker->randomElement(self::$articleImages);

            $article
                ->setAuthor($this->getRandomReference(User::class))
                ->setVoteCount(rand(0, 10))
                ->setImageFilename($this->articleFileUploader->uploadFile(new File(dirname(dirname(__DIR__)) . '/public/images/' . $fileName, $fileName)))
            ;

            /** @var Tag[] $tags */
            $tags = [];
            for ($i = 0; $i < $this->faker->numberBetween(0, 5); $i++) {
                $tags[] = $this->getRandomReference(Tag::class);
            }

            foreach ($tags as $tag) {
                $article->addTag($tag);
            }

            for ($i = 0; $i < $this->faker->numberBetween(2, 10); $i++) {
                $this->generateComments($article, $manager);
            }
        });
    }


    /**
     * @param Article $article
     * @param ObjectManager $manager
     */
    private function generateComments(Article $article, ObjectManager $manager): void
    {
        $comment = (new Comment())
            ->setAuthorName('Усатый-Полосатый')
            ->setContent($this->commentContentProvider->get(
                'Моёслово',
                $this->faker->numberBetween(1, 5)
            ))
            ->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 day'))
            ->setArticle($article);

        if($this->faker->boolean(50)) {
            $comment->setDeletedAt($this->faker->dateTimeThisMonth);
        }

        $manager->persist($comment);
    }


    public function generateContent():string
    {
        $wordArray = ['статья', 'новость', 'ИТ', 'технологии', 'инженерия', 'роботы', 'производство', 'хакинг'];

        $word = (rand(0, 10) <= 7) ? $wordArray[rand(0, 7)] : null;

        $contentText = $this->articleContentProvider->get(1, $word, rand(1, 5));

        if (strlen($contentText) >= 990) {
            $contentText = substr($contentText, 0, stripos($contentText, ' ', 990));
        }

        return $contentText;
    }

    public function generateKeywords(int $count = 0):string
    {
        $wordArray = ['статья', 'новость', 'ИТ', 'технологии', 'инженерия', 'роботы', 'производство', 'хакинг'];

        for ($i = 0; $i < $count; $i++) {
            $text = $wordArray[$i] . ' ';
        }

        return $text;
    }

    public function getDependencies()
    {
        return [
            TagFixtures::class,
        ];
    }

}
