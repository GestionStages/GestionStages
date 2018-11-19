<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EntreprisesRepository extends EntityRepository {

	public function findLikeName($name)
	{
		$entreprises = $this->getEntityManager()
			->createQuery('
					SELECT e
					FROM AppBundle:Entreprises e
					WHERE e.nomentreprise LIKE :name
					')
			->setParameter('name', '%'.$name.'%')
			->getResult();

		return $entreprises;
	}

}