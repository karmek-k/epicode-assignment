<?php

namespace App\Repository;

use App\Entity\JobOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobOffer>
 *
 * @method JobOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobOffer[]    findAll()
 * @method JobOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobOffer::class);
    }

    public function save(JobOffer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JobOffer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findWithListFormQuery(?int $maxDaysAgo = null, ?string $searchQuery = null): Query
    {
        $qb = $this->createQueryBuilder('o');

        if (!empty($maxDaysAgo) && $maxDaysAgo > 0) {
            $date = new \DateTimeImmutable("now - $maxDaysAgo days");

            $qb->andWhere('o.creationDate >= :date')->setParameter('date', $date);
        }

        if (!empty($searchQuery)) {
            $qb
                ->andWhere('LOWER(o.jobName) LIKE LOWER(:query)')
                ->setParameter('query', '%' . $searchQuery . '%');
        }

        return $qb
            ->orderBy('o.creationDate', 'DESC')
            ->getQuery();
    }

    /** @return JobOffer[] */
    public function findWithListForm(?int $maxDaysAgo = null, ?string $searchQuery = null): array
    {
        return $this->findWithListFormQuery($maxDaysAgo, $searchQuery)->getResult();
    }

//    /**
//     * @return JobOffer[] Returns an array of JobOffer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JobOffer
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
