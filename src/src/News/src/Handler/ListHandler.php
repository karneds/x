<?php

declare(strict_types=1);

namespace News\Handler;


use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use News\Contract\NewsServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListHandler implements RequestHandlerInterface
{

    public function __construct(
        private readonly NewsServiceInterface $newsService,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getQueryParams();
        $page = $data['page'];
        $limit = $data['limit'];

        $news = $this->newsService->findAll($page, $limit);
        $data = [];
        foreach($news as $item) {
            $data[] = [
                'id' => $item->getId(),
                'title' => $item->getTitle(),
                'text' => $item->getText(),
                'created' => $item->getCreated()->format('c')
            ];
        }
        return new JsonResponse($data, StatusCodeInterface::STATUS_OK);
    }
}
