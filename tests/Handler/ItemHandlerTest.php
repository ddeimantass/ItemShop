<?php

namespace App\Tests\Handler;

use App\Entity\Item;
use App\Exception\InsufficientQuantityException;
use App\Handler\ItemHandler;
use App\Repository\ItemRepository;
use App\Service\ItemService;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ItemHandlerTest extends TestCase
{
    /** @var ItemRepository */
    private $repository;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ItemService */
    private $itemService;

    /** @var LoggerInterface */
    private $logger;

    /** @var ItemHandler */
    private $handler;

    public function setUp(): void
    {
        $this->repository = $this->createMock(ItemRepository::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->itemService = $this->createMock(ItemService::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->handler = new ItemHandler(
            $this->repository,
            $this->serializer,
            $this->itemService,
            $this->logger
        );
    }

    public function testReduce()
    {
        $item = new Item();
        $this->itemService->expects($this->once())
            ->method('reduce')
            ->with($this->equalTo($item));

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->with($this->equalTo($item), $this->equalTo('json'))
            ->willReturn('{}');

        $expected = new JsonResponse('{}', Response::HTTP_OK, [], true);
        $this->assertEquals($expected, $this->handler->reduce($item));
    }

    public function testReduceError()
    {
        $item = new Item();
        $this->itemService->expects($this->once())
            ->method('reduce')
            ->with($this->equalTo($item))
            ->willThrowException(new InsufficientQuantityException());

        $message = '{"message": "Insufficient item quantity"}';
        $expected = new JsonResponse($message, Response::HTTP_BAD_REQUEST, [], true);
        $this->assertEquals($expected, $this->handler->reduce($item));
    }
}
