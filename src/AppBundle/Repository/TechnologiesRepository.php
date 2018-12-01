<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TechnologiesRepository extends EntityRepository {

	public function findLikeName($name)
	{
		$technologies = $this->getEntityManager()
			->createQuery('
					SELECT t
					FROM AppBundle:Technologies t
					WHERE t.nomTechnologie LIKE :name
					')
			->setParameter('name', '%'.$name.'%')
			->getResult();

		return $technologies;
	}

}