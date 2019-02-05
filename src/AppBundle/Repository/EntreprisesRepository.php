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

    public function findEnattente(){
        return $this->createQueryBuilder('e')
            ->where('e.codeetat=1')
            ->addorderBy('e.nomentreprise')
            ->getQuery()->getResult();
    }

    public function findValid(){
        return $this->createQueryBuilder('e')
            ->where('e.codeetat=2')
            ->addorderBy('e.nomentreprise')
            ->getQuery()->getResult();
    }

    public function nbEnAttente() {
        $qb = $this->createQueryBuilder('e');
        $qb->select($qb->expr()->count('e'));
        $qb->where('e.codeetat = 1');
        $query = $qb->getQuery();
        $singleScalar = $query->getSingleScalarResult();
        return $singleScalar;

    }

    public function nbValid() {
        $qb = $this->createQueryBuilder('e');
        $qb->select($qb->expr()->count('e'));
        $qb->where('e.codeetat = 2');
        $query = $qb->getQuery();
        $singleScalar = $query->getSingleScalarResult();
        return $singleScalar;

    }
}