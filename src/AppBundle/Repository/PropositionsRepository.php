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

    public function orderedlist() {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.dateajout', 'DESC')
            ->getQuery();

        return $query->getResult();
    }

    public function filter($classes, $domaines, $technos) {
        $query = $this->createQueryBuilder('p')
            ->where('p.codeetat = 2');

        if (!is_null($classes)) {
            $query->innerJoin('p.codeclasse','c')
                ->andWhere('c.codeclasse IN (:classes)')
                ->setParameter('classes', $classes);
        }

        if (!is_null($domaines)) {
            $query->join('p.codeentreprise', 'e', 'WITH', 'p.codeentreprise=e.codeentreprise')
                ->innerJoin('e.codedomaine','d')
                ->andWhere('d.codedomaine IN (:domaines)')
                ->setParameter('domaines', $domaines);
        }

        if (!is_null($technos)) {
            $query->innerJoin('p.codetechnologie','t')
                ->andWhere('t.codetechnologie IN (:technologies)')
                ->setParameter('technologies', $technos);
        }

        return $query->orderBy('p.dateajout', 'DESC')
                    ->getQuery()
                    ->getResult();
    }
}