<?php

declare(strict_types=1);

namespace App\Controller;

use App\Handler\ItemHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private ItemHandler $handler;

    public function __construct(ItemHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("", methods="GET")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', ['items' => $this->handler->getList()]);
    }
}