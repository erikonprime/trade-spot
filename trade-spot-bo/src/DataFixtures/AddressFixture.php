<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AddressFixture  extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $address = [
            [
                'city' => 'Riga',
                'country' => 'Latvia',
                'street' => 'random random',
                'zipCode' => 'LV-1010',
            ],
            [
                'city' => 'Rezekne',
                'country' => 'Latvia',
                'street' => 'random random',
                'zipCode' => 'LV-1123',
            ],
            [
                'city' => 'Venspils',
                'country' => 'Latvia',
                'street' => 'random random',
                'zipCode' => 'LV-567',
            ],
        ];

        foreach ($address as $k => $data) {
            $newAddress = new Address();
            $newAddress
                ->setCity($data['city'])
                ->setPhone((string)random_int(10000000,20000000))
                ->setCountry($data['country'])
                ->setStreet($data['street'])
                ->setZipCode($data['city']);


            $manager->persist($newAddress);

            $this->addReference(sprintf('address_%s', $k), $newAddress);
        }

        $manager->flush();
    }
}
