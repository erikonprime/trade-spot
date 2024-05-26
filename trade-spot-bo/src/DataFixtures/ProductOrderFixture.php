<?php

namespace App\DataFixtures;

use App\Entity\ProductOrder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductOrderFixture  extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $productsOrder = [
            [
                'customer_id' =>  $this->getReference('account_0'),
                'product_id' => $this->getReference('product_0'),
            ],
            [
                'customer_id' =>  $this->getReference('account_2'),
                'product_id' => $this->getReference('product_1'),
            ],
            [
                'customer_id' =>  $this->getReference('account_0'),
                'product_id' => $this->getReference('product_2'),
            ],
        ];

        foreach ($productsOrder as $k => $order) {
            $newOrder = new ProductOrder();
            $newOrder
                ->setProduct($order['product_id'])
                ->setCustomer($order['customer_id']);

            $manager->persist($newOrder);

            $this->addReference(sprintf('product_order_%s', $k), $newOrder);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixture::class,
            AccountFixture::class,
        ];
    }
}
