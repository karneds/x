<?php

declare(strict_types=1);

namespace News\Entity;

enum Status: int
{
    case Draft = 0;

    case Publicated = 1;


    case Deleted = -1;
}