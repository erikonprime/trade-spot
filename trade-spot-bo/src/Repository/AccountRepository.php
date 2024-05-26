<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Account>
 *
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    public function getMaxId(): int
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('max(a.id)')
            ->from( Account::class, 'a')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByIdList(array $idList): array
    {
        $queryBuilder = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from(Account::class, 'a')
            ->innerJoin('a.product', 'product')
            ->addSelect('product')
            ->leftJoin('a.productOrders', 'productOrders')
            ->addSelect('productOrders')
            ->leftJoin('a.address', 'address')
            ->addSelect('address')
            ->where('a.id IN (:idList)')
            ->setParameter('idList', $idList);

        return $queryBuilder->getQuery()->getResult();
    }
}
