<?php

declare(strict_types=1);

namespace News;
use Doctrine\ORM\EntityManagerInterface;
use News\Contract\NewsServiceInterface;
use News\Entity\News;
use News\Entity\Status;
use News\Repository\NewsRepository;
use Ramsey\Uuid\UuidInterface;

class NewsService implements NewsServiceInterface
{

    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }

    public function findById(UuidInterface $id): News
    {
        return $this->getRepository()->findById($id);
    }


    public function findAll(int $page = 1, int $limit = 10): iterable
    {
        $offset =  ($page - 1) * $limit;
        return $this->getRepository()->findBy([
           'status' => Status::Publicated
        ], [
            'created' => 'DESC'
        ], $limit, $offset);
    }

    public function create(string $title, string $text): News
    {
        $news = new News($title, $text);
        $this->em->persist($news);
        $this->em->flush();
        return $news;
    }


    public function delete(UuidInterface $id): void
    {
        $news = $this->findById($id);
        $this->em->remove($news);
        $this->em->flush();
    }


    private function getRepository(): NewsRepository
    {
        return $this->em->getRepository(News::class);
    }

}