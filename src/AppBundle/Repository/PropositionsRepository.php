<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PropositionsRepository extends EntityRepository {

    public function nbEnAttenteValid()
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select($qb->expr()->count('a'));
        $qb->where('a.codeetat = 1');
        $query = $qb->getQuery();
        $singleScalar = $query->getSingleScalarResult();
        return $singleScalar;

    }



}