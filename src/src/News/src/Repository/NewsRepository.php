<?php

declare(strict_types=1);

namespace News\Repository;

use Doctrine\ORM\EntityRepository;
use News\Entity\News;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends EntityRepository<News>
 */
class NewsRepository extends EntityRepository
{

    public function findById(UuidInterface $id): ?News
    {
        return $this->find((string) $id);
    }
}