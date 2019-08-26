<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 26/08/19
 * Time: 11:34
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Movement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movement[]    findAll()
 * @method Movement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovementRepository extends ServiceEntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movement::class);
    }

    // /**
    //  * @return Movement[] Returns an array of Movement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Movement
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
