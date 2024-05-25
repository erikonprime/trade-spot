<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public const ELECTRONIC = 'electronics';
    public const TRANSPORT = 'transport';
    public const ANIMAL = 'animals';


    public function load(ObjectManager $manager): void
    {
        $categories = [
            [
                'name' => self::ELECTRONIC,
            ],
            [
                'name' => self::TRANSPORT,
            ],
            [
                'name' => self::ANIMAL,
            ],
        ];

        foreach ($categories as $category) {
            $cat = new Category();
            $cat
                ->setName($category['name']);

            $this->addReference($category['name'], $cat);

            $manager->persist($cat);
        }

        $manager->flush();
    }
}
