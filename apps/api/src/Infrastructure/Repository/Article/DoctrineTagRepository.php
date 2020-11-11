<?php

namespace Smartengo\Infrastructure\Repository\Article;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Smartengo\Domain\Article\Entity\Tag;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Domain\Core\NotFoundException;
use Smartengo\Domain\Core\UnexpectedResultException;
use Smartengo\Infrastructure\Doctrine\Repository;

class DoctrineTagRepository extends Repository implements TagRepository
{
    protected function getEntityClass(): string
    {
        return Tag::class;
    }

    public function save(Tag $tag): void
    {
        $this->getEntityManager()->persist($tag);
        $this->getEntityManager()->flush();
    }

    public function get(string $id): Tag
    {
        try {
            return $this
                ->createQueryBuilder('t')
                ->where('t.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            throw new NotFoundException(sprintf('The tag with the id %s was not found.', $id), 0, $e);
        } catch (NonUniqueResultException $e) {
            throw new UnexpectedResultException($e);
        }
    }

    public function remove(Tag $tag): void
    {
        $this->getEntityManager()->remove($tag);
        $this->getEntityManager()->flush();
    }
}
