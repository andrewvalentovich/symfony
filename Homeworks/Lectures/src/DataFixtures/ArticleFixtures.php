<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends BaseFixtures
{
    private static $articleTitles = [
        'Есть ли жизнь после девятой жизни?',
        'Когда в машинах поставят лоток?',
        'В погоне за красной точкой',
        'В чем смысл жизни сосисок',
    ];

    private static $articleAuthors = [
        'Николай',
        'Mr White',
        'Барон Сосискин',
        'Сметанка',
        'Рыжик',
    ];

    private static $articleImages = [
        'car1.jpg',
        'car2.jpg',
        'car3.jpeg',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article) use ($manager) {
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setBody('Lorem ipsum **красная точка** dolor sit amet, consectetur adipiscing elit, sed
do eiusmod tempor incididunt [Сметанка](/) ut labore et dolore magna aliqua
' . $this->faker->paragraphs($this->faker->numberBetween(2, 5), true))
            ;

            if ($this->faker->boolean(60)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $article
                ->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setLikeCount($this->faker->numberBetween(0, 10))
                ->setImageFilename($this->faker->randomElement(self::$articleImages))
            ;

            for ($i = 0; $i < $this->faker->numberBetween(2, 10); $i++) {
                $this->addComment($article, $manager);
            }

        });
    }

    /**
     * @param Article $article
     * @param ObjectManager $manager
     */
    private function addComment(Article $article, ObjectManager $manager): void
    {
        $comment = (new Comment())
            ->setAuthorName('Усатый-Полосатый')
            ->setContent($this->faker->paragraph)
            ->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 day'))
            ->setArticle($article);

        if($this->faker->boolean(50)) {
            $comment->setDeletedAt($this->faker->dateTimeThisMonth);
        }

        $manager->persist($comment);
    }
}
