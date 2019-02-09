<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Entreprises;
use Doctrine\ORM\EntityRepository;

class ContactsRepository extends EntityRepository {
    public function getEntrepriseContactsOrdered(Entreprises $entreprise) {
        return $this->createQueryBuilder('c')
                    ->where('c.codeentreprise = ?1')
                    ->addOrderBy('c.nomcontact', 'ASC')
                    ->addOrderBy('c.prenomcontact', 'ASC')
                    ->setParameter(1, $entreprise->getCodeentreprise())
                    ->getQuery()->getResult();
    }
}