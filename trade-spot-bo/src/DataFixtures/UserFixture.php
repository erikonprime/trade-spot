<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture  extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'email' => 'jon@gmail.com',
                'roles' => [],
            ],
            [
                'email' => 'mike@gmail.com',
                'roles' => [],
            ],
            [
                'email' => 'chriss@gmail.com',
                'roles' => [],
            ],
        ];

        foreach ($users as $k =>  $user) {
            $newUser = new User();
            $newUser
                ->setEmail($user['email'])
                ->setRoles($user['roles']);

            $newUser->setPassword($this->hasher->hashPassword($newUser, 'qwerty'));
            $manager->persist($newUser);

            $this->addReference(sprintf('user_%s', $k), $newUser);
        }

        $manager->flush();
    }
}
