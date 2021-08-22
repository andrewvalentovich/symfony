<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 100, function (Comment $comment) {
            $comment
                ->setAuthorName($this->faker->name)
                ->setContent($this->faker->paragraph)
                ->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 day'))
                ->setArticle($this->getRandomReference(Article::class))
            ;

            if ($this->faker->boolean) {
                $comment->setDeletedAt($this->faker->dateTimeThisMonth);
            }
        });
    }

    private $referencesIndex = [];

    protected function getRandomReference($className)
    {
        if (!isset($this->referencesIndex[$className])) {
            $this->referencesIndex[$className] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $reference) {
                if (strpos($key, $className . '|') === 0) {
                    $this->referencesIndex[$className][] = $key;
                }
            }
        }

        if (empty($this->referencesIndex[$className])) {
            throw new \Exception('Не найдены ссылки на класс: ' . $className);
        }

        return $this->getReference($this->faker->randomElement($this->referencesIndex[$className]));
    }

    public function getDependencies()
    {
        return [
          ArticleFixtures::class,
        ];
    }
}
