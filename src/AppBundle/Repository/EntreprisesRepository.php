<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EntreprisesRepository extends EntityRepository {

	public function findLikeName($name)
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Entreprises');
		$query = $repository->createQueryBuilder('e')
			->where('e.nomEntreprise LIKE :name')
			->setParameter('name', $name)
			->getQuery();

		return $query->getResult();
	}

}