<?php

namespace App\DataFixtures;

use App\Entity\Band;
use App\Entity\User;
use App\Entity\UserBand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserBandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // loop into users
        for ($i = 1; $i < 65; $i++) {
            if(rand(1,2) != 2) {
                continue;
            }
            // loop into groups
            for ($y = 1; $y < 8; $y++) {
                if(rand(1,3) < 3) {
                    continue;
                }
                /** @var User $user */
                $user = $this->getReference('user'.$i);
                /** @var Band $band */
                $band = $this->getReference('band'.$y);

                $userBand = new UserBand();
                $userBand->setUser($user);
                $userBand->setBand($band);

                $manager->persist($userBand);
            }
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            BandFixtures::class,
            UserFixtures::class
        );
    }
}