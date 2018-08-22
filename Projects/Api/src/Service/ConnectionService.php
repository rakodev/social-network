<?php

namespace App\Service;


use App\Entity\Band;
use App\Entity\User;
use App\Entity\UserBand;
use App\Entity\UserUser;
use App\Repository\BandRepository;
use App\Repository\UserBandRepository;
use App\Repository\UserRepository;
use App\Repository\UserUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ConnectionService
 * @package App\Service
 */
class ConnectionService
{
    /** @var EntityManagerInterface $entityManager */
    protected $entityManager;

    /**
     * ConnectionService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        /** @var EntityManagerInterface entityManager */
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $bandId
     * @param int $userAId
     * @param int $userBId
     * @return bool
     * @throws \Exception
     */
    public function createConnection(int $bandId, int $userAId, int $userBId)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);

        /** @var BandRepository $bandRepository */
        $bandRepository = $this->entityManager->getRepository(Band::class);

        /** @var User $userA */
        $userA = $userRepository->findOneBy(['id' => $userAId]);
        if(! $userA instanceof User) {
            throw new NotFoundHttpException($userAId. " user not found");
        }
        /** @var User $userB */
        $userB = $userRepository->findOneBy(['id' => $userBId]);
        if(! $userB instanceof User) {
            throw new NotFoundHttpException($userBId. " user not found");
        }
        /** @var Band $band */
        $band = $bandRepository->findOneBy(['id' => $bandId]);
        if(! $band instanceof Band) {
            throw new NotFoundHttpException($bandId. " band not found");
        }

        if(!$this->areInSameBand($band, $userA, $userB)) {
            throw new \Exception("They are not in the same band", 400);
        }

        /** @var UserUserRepository $userUserRepository */
        $userUserRepository = $this->entityManager->getRepository(UserUser::class);

        $connectionIdA = $userUserRepository->connect($userA->getId(), $userB->getId());
        if (is_int($connectionIdA) && $connectionIdA > 0) {
            $connectionIdB = $userUserRepository->connect($userB->getId(), $userA->getId());
        }

        if (!$connectionIdA || !$connectionIdB) {
            throw new \Exception("We can't connect users");
        }

        return true;
    }

    /**
     * @param Band $band
     * @param User $userA
     * @param User $userB
     * @return bool
     */
    public function areInSameBand(Band $band, User $userA, User $userB)
    {
        /** @var UserBandRepository $userBandRepository */
        $userBandRepository = $this->entityManager->getRepository(UserBand::class);

        return ($userBandRepository->getMutualBand($band->getId(), $userA->getId(), $userB->getId())) ? true : false;
    }
}