<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Statement;
use Symfony\Bridge\Doctrine\RegistryInterface;
use PDO;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $page
     * @param int $maxResult
     * @return array
     */
    public function getUsers(int $page, int $maxResult)
    {
        $conn = $this->_em->getConnection();

        $limitStart = ($page - 1) * $maxResult;

        $query = '  SELECT id, name, created_at
                    FROM user 
                    ORDER BY id ASC 
                    LIMIT :limitStart, :limitEnd';

        /** @var Statement $stmt */
        $stmt = $conn->prepare($query);
        $stmt->bindParam('limitStart',$limitStart, PDO::PARAM_INT);
        $stmt->bindParam('limitEnd',$maxResult, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return mixed
     */
    public function getTotalUsersCount()
    {
        $conn = $this->_em->getConnection();
        $query = '  SELECT COUNT(id) as nbr_users
                    FROM user
                    LIMIT 1';

        /** @var Statement $stmt */
        $stmt = $conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}
