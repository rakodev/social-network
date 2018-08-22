<?php

namespace App\Repository;

use App\Entity\UserUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Statement;
use Symfony\Bridge\Doctrine\RegistryInterface;
use PDO;

/**
 * @method UserUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserUser[]    findAll()
 * @method UserUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserUserRepository extends ServiceEntityRepository
{
    /**
     * UserUserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserUser::class);
    }

    /**
     * @param int $fromUserId
     * @param int $toUserId
     * @return bool|int
     */
    public function connect(int $fromUserId, int $toUserId)
    {

        $query = '  INSERT into '.$this->getClassMetadata()->getTableName().'
                    (user_a_id, user_b_id, created_at)
                    VALUES
                    (:fromUserId, :toUserId, :createdAt)';
        $conn = $this->_em->getConnection();
        /** @var Statement $stmt */
        $stmt = $conn->prepare($query);
        $stmt->bindParam('fromUserId',$fromUserId, PDO::PARAM_INT);
        $stmt->bindParam('toUserId',$toUserId, PDO::PARAM_INT);
        $datetime = date('Y-m-d H:i:s');
        $stmt->bindParam('createdAt', $datetime, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount()) {
            return (int) $conn->lastInsertId();
        }
        return false;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getUserConnections(int $userId)
    {
        $conn = $this->_em->getConnection();

        $query = '  SELECT t2.id as user_id, t2.name, t1.created_at
                    FROM user_user AS t1
                    left JOIN user as t2 on t1.user_b_id = t2.id
                    where t1.user_a_id = :userId';

        /** @var Statement $stmt */
        $stmt = $conn->prepare($query);
        $stmt->bindParam('userId',$userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
