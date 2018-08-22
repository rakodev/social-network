<?php

namespace App\Repository;

use App\Entity\UserBand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Statement;
use Symfony\Bridge\Doctrine\RegistryInterface;
use PDO;

/**
 * @method UserBand|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserBand|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserBand[]    findAll()
 * @method UserBand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserBandRepository extends ServiceEntityRepository
{
    /**
     * UserBandRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserBand::class);
    }

    /**
     * @param int $bandId
     * @param int $userAId
     * @param int $userBId
     * @return mixed
     */
    public function getMutualBand(int $bandId, int $userAId, int $userBId)
    {
        $conn = $this->_em->getConnection();

        $query = '  SELECT band_id
                    FROM user_band
                    WHERE user_id= :userAId
                    AND band_id = (
                      SELECT band_id FROM user_band WHERE user_id = :userBId AND band_id = :bandId
                    )
                    LIMIT 1';

        /** @var Statement $stmt */
        $stmt = $conn->prepare($query);
        $stmt->bindParam('bandId',$bandId, PDO::PARAM_INT);
        $stmt->bindParam('userAId',$userAId, PDO::PARAM_INT);
        $stmt->bindParam('userBId',$userBId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @param int $bandId
     * @return array
     */
    public function getBandUsers(int $bandId)
    {
        $conn = $this->_em->getConnection();

        $query = '  SELECT t1.user_id, t2.name
                    FROM user_band as t1 
                    LEFT JOIN user as t2 on t1.user_id = t2.id
                    WHERE t1.band_id= :bandId';

        /** @var Statement $stmt */
        $stmt = $conn->prepare($query);
        $stmt->bindParam('bandId',$bandId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param int $bandId
     * @param int $userAId
     * @return array
     */
    public function getPotentialConnectionUsers(int $bandId, int $userAId)
    {
        $conn = $this->_em->getConnection();

        $query = '  SELECT t1.user_id, t2.name
                    FROM user_band as t1 
                    LEFT JOIN user as t2 on t1.user_id = t2.id
                    WHERE t1.band_id= :bandId
                    AND t1.user_id <> :userAId
                    AND t1.user_id NOT IN (
                        SELECT user_b_id FROM user_user WHERE user_a_id = :userAId
                    )';

        /** @var Statement $stmt */
        $stmt = $conn->prepare($query);
        $stmt->bindParam('bandId',$bandId, PDO::PARAM_INT);
        $stmt->bindParam('userAId',$userAId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
