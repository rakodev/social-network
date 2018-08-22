<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 65; $i++) {
            $user = new User();
            $user->setName('User '.$i);
            $manager->persist($user);

            $this->addReference('user'.$i, $user);
        }

        $manager->flush();

    }
}