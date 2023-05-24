<?php

namespace App\Repository;

use App\Entity\TestUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestUser>
 *
 * @method TestUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestUser[]    findAll()
 * @method TestUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestUser::class);
    }

    public function save(TestUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TestUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param int[] $userTypes
     * @return TestUser[]
     */
    public function findUsersByCriterias(?bool $isActive, ?bool $isMember, ?\DateTimeImmutable $lastLoginAtStart, ?\DateTimeImmutable $lastLoginAtEnd, array $userTypes): array
    {
        $queryBuilder = $this->createQueryBuilder('u');

        if (null !== $isActive) {
            $queryBuilder
                ->andWhere('u.isActive = :isActive')
                ->setParameter('isActive', $isActive);
        }

        if (null !== $isMember) {
            $queryBuilder
                ->andWhere('u.isMember = :isMember')
                ->setParameter('isMember', $isMember);
        }

        if ($lastLoginAtStart) {
            $queryBuilder
                ->andWhere('u.lastLoginAt >= :start')
                ->setParameter('start', $lastLoginAtStart);
        }

        if ($lastLoginAtEnd) {
            $queryBuilder
                ->andWhere('u.lastLoginAt <= :end')
                ->setParameter('end', $lastLoginAtEnd);
        }

        if (\count($userTypes) > 0) {
            $queryBuilder
                ->andWhere('u.userType IN (:userTypes)')
                ->setParameter('userTypes', $userTypes);
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}
