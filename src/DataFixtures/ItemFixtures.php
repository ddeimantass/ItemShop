<?php

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $item = new Item();
            $item->setPrice(\mt_rand(15, 150))
                ->setQuantity(\mt_rand(1, 10))
                ->setName('Item ' . $i);
            $manager->persist($item);
        }

        $manager->flush();
    }
}
