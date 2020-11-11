<?php

namespace Smartengo\Infrastructure\Repository\Article;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\NotFoundException;
use Smartengo\Domain\Core\UnexpectedResultException;
use Smartengo\Infrastructure\Doctrine\Repository;

class DoctrineArticleRepository extends Repository implements ArticleRepository
{
    public function save(Article $article): void
    {
        $this->getEntityManager()->persist($article);
        $this->getEntityManager()->flush();
    }

    public function get(string $id): Article
    {
        try {
            return $this
                ->createQueryBuilder('a')
                ->where('a.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            throw new NotFoundException(sprintf('The article with the id %s was not found.', $id), 0, $e);
        } catch (NonUniqueResultException $e) {
            throw new UnexpectedResultException($e);
        }
    }

    public function getAll(): array
    {
        return $this
            ->createQueryBuilder('a')
            ->getQuery()
            ->getArrayResult();
    }

    public function getByTags(array $tags): array
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->leftJoin('a.tags', 't');

        foreach ($tags as $i => $tag) {
            $qb
                ->orWhere(sprintf('t.title = :title%s', $i))
                ->setParameter(sprintf('title%s', $i), $tag);
        }

        return $qb
            ->getQuery()
            ->getArrayResult();
    }

    public function remove(Article $article): void
    {
        $this->getEntityManager()->remove($article);
        $this->getEntityManager()->flush();
    }

    protected function getEntityClass(): string
    {
        return Article::class;
    }
}
