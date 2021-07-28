<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

     /**
      * @return Article[] Returns an array of Article objects
      */

    public function findLatestPublished()
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $this->published($this->latest($qb))
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLatest(QueryBuilder $qb = null)
    {
        return $this->latest($qb)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findPublished(QueryBuilder $qb = null)
    {
        return $this->published($qb)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $qb ?? $this->createQueryBuilder('a');
    }

    private function published(QueryBuilder $qb = null)
    {
        return $this->getOrCreateQueryBuilder($qb)->andWhere('a.publishedAt IS NOT NULL');
    }

    private function latest(QueryBuilder $qb = null)
    {
        return $this->getOrCreateQueryBuilder($qb)->OrderBy('a.publishedAt', 'DESC');
    }

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
