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

    public function nbValid() {
        $qb = $this->createQueryBuilder('a');
        $qb->select($qb->expr()->count('a'));
        $qb->where('a.codeetat = 2');
        $query = $qb->getQuery();
        $singleScalar = $query->getSingleScalarResult();
        return $singleScalar;

    }

    public function nbAffecte() {
        $qb = $this->createQueryBuilder('a');
        $qb->select($qb->expr()->count('a'));
        $qb->where('a.codeetat = 3');
        $query = $qb->getQuery();
        $singleScalar = $query->getSingleScalarResult();
        return $singleScalar;

    }

    public function nbArchive() {
        $qb = $this->createQueryBuilder('a');
        $qb->select($qb->expr()->count('a'));
        $qb->where('a.codeetat = 4');
        $query = $qb->getQuery();
        $singleScalar = $query->getSingleScalarResult();
        return $singleScalar;

    }

    public function nbRefuse() {
        $qb = $this->createQueryBuilder('a');
        $qb->select($qb->expr()->count('a'));
        $qb->where('a.codeetat = 5');
        $query = $qb->getQuery();
        $singleScalar = $query->getSingleScalarResult();
        return $singleScalar;

    }


}