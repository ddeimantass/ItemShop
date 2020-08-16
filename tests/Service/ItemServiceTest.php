<?php

namespace App\Tests\Service;

use App\Entity\Item;
use App\Exception\InsufficientQuantityException;
use App\Service\ItemService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ItemServiceTest extends TestCase
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ItemService */
    private $itemService;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->itemService = new ItemService($this->entityManager);
    }

    public function testReduce()
    {
        $item = $this->createMock(Item::class);
        $item->expects($this->once())
            ->method('getQuantity')
            ->willReturn(10);
        $item->expects($this->once())
            ->method('getPrice')
            ->willReturn(100);
        $item->expects($this->once())
            ->method('setQuantity')
            ->with($this->equalTo(9))
            ->willReturn($item);
        $item->expects($this->once())
            ->method('setPrice')
            ->with($this->equalTo(90));

        $this->entityManager ->expects($this->once())
            ->method('flush');
        $this->entityManager ->expects($this->once())
            ->method('refresh')
            ->with($this->equalTo($item));

        $this->itemService->reduce($item);
    }

    public function testReduceError()
    {
        $item = $this->createMock(Item::class);
        $item->expects($this->once())
            ->method('getQuantity')
            ->willReturn(0);

        $this->expectException(InsufficientQuantityException::class);

        $this->itemService->reduce($item);
    }
}
