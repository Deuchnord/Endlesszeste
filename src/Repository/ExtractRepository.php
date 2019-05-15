<?php

/*
 * This file is part of Endlesszeste.
 *
 * Endlesszeste is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Endlesszeste is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Endlesszeste.  If not, see <https://www.gnu.org/licenses/agpl.html>.
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Extract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Extract find($id, $lockMode = null, $lockVersion = null)
 * @method null|Extract findOneBy(array $criteria, array $orderBy = null)
 * @method Extract[]    findAll()
 * @method Extract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtractRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Extract::class);
    }

    // /**
    //  * @return Extract[] Returns an array of Extract objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Extract
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
