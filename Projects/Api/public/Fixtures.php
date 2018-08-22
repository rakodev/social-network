<?php

//namespace App\DataFixtures;
//
//use App\Entity\Band;
//use App\Entity\User;
//use App\Entity\UserUser;
//use App\Repository\UserRepository;
//use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Common\Persistence\ObjectManager;
//
//class Fixtures extends Fixture
//{
//    public function load(ObjectManager $manager)
//    {
//        for ($i = 1; $i < 65; $i++) {
//            $user = new User();
//            $user->setName('User '.$i);
//            $manager->persist($user);
//        }
//
//        $manager->flush();
//
//        for ($i = 1; $i < 33; $i++) {
//
//            /** @var UserRepository $rep */
//            $rep = $manager->getRepository(User::class);
//
//            $userA = $rep->findOneBy(['id' => $i]);
//            $userB = $rep->findOneBy(['id' => ($i + 32)]);
//
//            $userRelationA = new UserUser();
//            $userRelationA->setUserA($userA);
//            $userRelationA->setUserB($userB);
//
//            $userRelationB = new UserUser();
//            $userRelationB->setUserA($userB);
//            $userRelationB->setUserB($userA);
//
//            $manager->persist($userRelationA);
//            $manager->persist($userRelationB);
//        }
//
//        $manager->flush();
//
//        for ($i = 1; $i < 7; $i++) {
//            $band = new Band();
//            $band->setName('Name '. $i);
//            $band->setDescription('Description '. $i);
//            $manager->persist($band);
//        }
//
//        $manager->flush();
//
//    }
//}