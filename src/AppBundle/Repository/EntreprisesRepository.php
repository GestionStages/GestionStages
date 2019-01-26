<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EntreprisesRepository extends EntityRepository {

	public function findLikeName($name)
	{
        return $this->createQueryBuilder('e')
                    ->where('e.blacklister=0')
                    ->andWhere('e.nomentreprise LIKE ?1')
                    ->addOrderBy('e.nomentreprise', 'ASC')
                    ->setParameter(1, "%".$name."%")
                    ->getQuery()->getResult();
	}

    public function findBlacklisted($blacklisted = true) {
        return $this->createQueryBuilder('e')
                    ->where('e.blacklister=?1')
                    ->setParameter(1, intval($blacklisted))
                    ->addOrderBy('e.nomentreprise', 'ASC')
                    ->getQuery()->getResult();
    }
}