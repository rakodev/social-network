<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BandFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 8; $i++) {
            $band = new Band();
            $band->setName('Name '. $i);
            $band->setDescription('Description '. $i);
            $manager->persist($band);

            $this->addReference('band'.$i, $band);
        }

        $manager->flush();

    }
}