<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RolesProf
 *
 * @ORM\Table(name="roles_prof")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RolesProfRepository")
 */
class RolesProf
{
    /**
     * @var int
     *
     * @ORM\Column(name="codeRole", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeRole;


    /**
     * Get codeRole
     *
     * @return int
     */
    public function getCodeRole()
    {
        return $this->codeRole;
    }

    /**
     * @ORM\Column(name="titreRole", type="string", length="255", nullable=false)
     */
    private $titreRole;


    /**
     * @ORM\Column(name="nomRole", type="string", length="255", nullable=false)
     */
    private $nomRole;

    /**
     * @return mixed
     */
    public function getTitreRole()
    {
        return $this->titreRole;
    }

    /**
     * @param mixed $titreRole
     */
    public function setTitreRole($titreRole)
    {
        $this->titreRole = $titreRole;
    }

    /**
     * @return mixed
     */
    public function getNomRole()
    {
        return $this->nomRole;
    }

    /**
     * @param mixed $nomRole
     */
    public function setNomRole($nomRole)
    {
        $this->nomRole = $nomRole;
    }
}

