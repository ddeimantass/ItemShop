<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\InsufficientQuantityException;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;

class ItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Item $item
     * @throws InsufficientQuantityException
     */
    public function reduce(Item $item): void
    {
        $quantity = $item->getQuantity();
        if (0 === $quantity) {
            throw new InsufficientQuantityException();
        }

        $item->setQuantity($quantity - 1)
            ->setPrice($item->getPrice() * 0.9);

        $this->entityManager->flush();
        $this->entityManager->refresh($item);
    }
}