<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TechnologiesRepository extends EntityRepository {

	public function findAcceptedLikeName($name) {
		$query = $this->createQueryBuilder('t')
		->innerJoin('t.codeproposition', 'cp')
		->innerJoin('cp.codeetat', 'ce')
		->where('ce.codeetat IN (2,4)') // seulement les propositions validées, affectées, archivées
		->andWhere('t.nomtechnologie LIKE ?1')
		->addOrderBy('t.nomtechnologie', 'ASC')
		->setParameter(1, "%" . $name . "%")
		->getQuery();

		return $query->getResult();
	}

}