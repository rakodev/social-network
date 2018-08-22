<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserBand;
use App\Entity\UserUser;
use App\Service\ConnectionService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserUserFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $connections = [];
        for ($i = 1; $i < 65; $i++) {
            /** @var User $userA */
            $userA = $this->getReference('user'.$i);
            for ($y = 1; $y < 65; $y++) {
                // Set random connections
                if($i == $y || rand(1,10) != 5 || in_array($i.'-'.$y, $connections) || in_array($y.'-'.$i, $connections)) {
                    continue;
                }
                /** @var User $userB */
                $userB = $this->getReference('user'.($y));


                $userRelationA = new UserUser();
                $userRelationA->setUserA($userA);
                $userRelationA->setUserB($userB);

                $userRelationB = new UserUser();
                $userRelationB->setUserA($userB);
                $userRelationB->setUserB($userA);

                $manager->persist($userRelationA);
                $manager->persist($userRelationB);

                $connections[] = $i.'-'.$y;
                $connections[] = $y.'-'.$i;
            }

        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            UserBandFixtures::class
        );
    }
}