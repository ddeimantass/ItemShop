<?php

declare(strict_types=1);

namespace App\Handler;

use App\Exception\InsufficientQuantityException;
use App\Entity\Item;
use App\Repository\ItemRepository;
use App\Service\ItemService;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ItemHandler
{
    private ItemRepository $repository;
    private SerializerInterface $serializer;
    private ItemService $itemService;
    private LoggerInterface $logger;

    public function __construct(
        ItemRepository $repository,
        SerializerInterface $serializer,
        ItemService $itemService,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->itemService = $itemService;
        $this->logger = $logger;
    }

    /**
     * @return Item[]
     */
    public function getList(): array
    {
        return $this->repository->findAll() ?? [];
    }

    /**
     * @param Item $item
     * @return Response
     */
    public function reduce(Item $item): Response
    {
        try {
            $this->itemService->reduce($item);
            $data = $this->serializer->serialize($item,'json');

            return new JsonResponse($data, Response::HTTP_OK, [], true);
        } catch (InsufficientQuantityException $exception) {
            $this->logger->warning($exception->getMessage(), $exception->getTrace());

            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST, [], true);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage(), $exception->getTrace());

            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
