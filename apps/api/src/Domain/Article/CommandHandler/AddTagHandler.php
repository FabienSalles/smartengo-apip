<?php

namespace Smartengo\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Command\AddTag;
use Smartengo\Domain\Article\Entity\Tag;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Domain\Core\CommandHandler;
use Smartengo\Domain\Core\InvalidCommandException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddTagHandler implements CommandHandler
{
    protected TagRepository $repository;
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator, TagRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function __invoke(AddTag $command): void
    {
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validate($command);

        if ($violations->count()) {
            throw new InvalidCommandException(AddTag::class, $violations);
        }

        $tag = Tag::createWith($command);
        $this->repository->save($tag);
    }
}
