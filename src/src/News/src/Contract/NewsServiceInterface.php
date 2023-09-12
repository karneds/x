<?php

declare(strict_types=1);

namespace News\Contract;

use News\Entity\News;
use Ramsey\Uuid\UuidInterface;


interface NewsServiceInterface
{

    public function findById(UuidInterface $id): News;

    public function findAll(int $page, int $limit): iterable;

    public function create(string $title, string $text): News;

    public function delete(UuidInterface $id): void;

}