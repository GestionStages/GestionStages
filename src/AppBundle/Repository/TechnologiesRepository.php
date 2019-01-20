<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TechnologiesRepository extends EntityRepository {

	public function findLikeName($name)
	{
        return $this->createQueryBuilder('t')
            ->where('t.nomtechnologie LIKE ?1')
            ->addOrderBy('t.nomtechnologie', 'ASC')
            ->setParameter(1, "%".$name."%")
            ->getQuery()->getResult();
	}

}