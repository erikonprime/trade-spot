<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AccountFixture  extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $accounts = [
            [
                'user' => $this->getReference('user_0'),
                'firstname' => 'Eriks',
                'lastName' =>'Flo',
                'address' => $this->getReference('address_0'),
            ],
            [
                'user' => $this->getReference('user_1'),
                'firstname' => 'Jon',
                'lastName' =>'Doe',
                'address' => $this->getReference('address_1'),
            ],
            [
                'user' => $this->getReference('user_2'),
                'firstname' => 'Markus',
                'lastName' =>'Riva',
                'address' => $this->getReference('address_2'),
            ],
        ];

        foreach ($accounts as $k => $account) {
            $newAccount = new Account();
            $newAccount
                ->setUser($account['user'])
                ->setFirstName($account['firstname'])
                ->setLastName($account['lastName'])
                ->setAddress($account['address']);


            $manager->persist($newAccount);

            $this->addReference(sprintf('account_%s', $k), $newAccount);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            AddressFixture::class,
        ];
    }
}
