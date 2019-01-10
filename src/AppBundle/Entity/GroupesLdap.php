<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupesLdap
 *
 * @ORM\Table(name="groupes_ldap")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupesLdapRepository")
 */
class GroupesLdap
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeGroupe;


    /**
     * Get id
     *
     * @return int
     */
    public function getCodeGroupe()
    {
        return $this->codeGroupe;
    }

    /**
     * @var string
     * @ORM\Column(name="ldapSection", type="string", length=255, nullable=false)
     */
    private $ldapSection;

    /**
     * @return string
     */
    public function getLdapSection()
    {
        return $this->ldapSection;
    }

    /**
     * @param string $ldapSection
     */
    public function setLdapSection($ldapSection)
    {
        $this->ldapSection = $ldapSection;
    }

    /**
     * @var boolean
     * @ORM\Column(name="isLicence", type="boolean", nullable=false)
     */
    private $isLicence;


    /**
     * Set isLicence
     *
     * @param boolean $isLicence
     */
    public function setIsLicence($isLicence)
    {
        $this->isLicence = $isLicence;
    }

    /**
     * Get isLicence
     *
     * @return boolean
     */
    public function getIsLicence()
    {
        return $this->isLicence;
    }
}
