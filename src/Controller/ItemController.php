<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Item;
use App\Handler\ItemHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/item")
 */
class ItemController extends AbstractController
{
    private ItemHandler $handler;

    public function __construct(ItemHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/{id}/reduce", methods="GET")
     * @param Item $item
     * @return Response
     */
    public function reduce(Item $item): Response
    {
        return $this->handler->reduce($item);
    }
}