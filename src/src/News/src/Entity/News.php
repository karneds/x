<?php

declare(strict_types=1);

namespace News\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use News\Repository\NewsRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
#[ORM\Table(name: 'news')]
final class News
{

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    #[ORM\Column(name: 'title', type: 'string')]
    private string $title;


    #[ORM\Column(name: 'text', type: 'string')]
    private string $text;

    
    #[ORM\Column(name: 'status', type: 'smallint', enumType: Status::class)]
    private Status $status;

    #[ORM\Column(name: 'created_date', type: 'datetime_immutable')]
    private readonly DateTimeImmutable $created;


    public function __construct(
        string $title,
        string $text
    )
    {
        $this->id = Uuid::uuid7();
        $this->title = $title;
        $this->text = $text;
        $this->created = new DateTimeImmutable();
        $this->status = Status::Draft;
    }


    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

}