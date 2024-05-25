<?php

namespace App\DataFixtures;

use App\Component\Doctrine\Types\EnumProductOrderStatus;
use App\Component\Doctrine\Types\EnumProductStatus;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixture  extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $products = [
            [
                'name' => 'LG TV',
                'category' => $this->getReference('electronics'),
                'account' => $this->getReference('account_1'),
                'price' => 100.99,
                'description' => 'Shop LG TVs to Transform Your Home Entertainment. Browse the Latest Smart TVs and Stunning Flat Screen TV Displays to Decide Which TV to Buy for Your Space.',
            ],
            [
                'name' => 'Welsh Corgi',
                'category' => $this->getReference('animals'),
                'account' => $this->getReference('account_0'),
                'price' => 0.99,
                'description' => 'The Welsh Corgi is a small type of herding dog that originated in Wales. The name corgi is derived from the Welsh words cor and ci, meaning "dwarf" and "dog", respectively. Two separate breeds are recognized: the Pembroke Welsh Corgi and the Cardigan Welsh Corgi. Physical differences are seen between the two breeds.',
            ],
            [
                'name' => 'BMW X2 sDrive18i',
                'category' => $this->getReference('transport'),
                'account' => $this->getReference('account_1'),
                'price' => 25,900,
                'description' => 'Luxury, performance, and versatility. The all-new 2024 BMW X2 makes a powerful entrance with its athletic design. Immerse yourself in a sumptuous interior, boasting state-of-the-art tech and complete comfort.',
            ],
        ];

        foreach ($products as $k => $product) {
            $newProduct = new Product();
            $newProduct
                ->setName($product['name'])
                ->setCategory($product['category'])
                ->setAccount($product['account'])
                ->setPrice($product['price'])
                ->setDescription($product['description']);

            $manager->persist($newProduct);

            $this->addReference(sprintf('product_%s', $k), $newProduct);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
            AccountFixture::class,
        ];
    }
}
