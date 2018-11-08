<?php

namespace AppBundle\Entity;

/**
 * Domaineactivite
 */
class Domaineactivite
{
    /**
     * @var string
     */
    private $nomdomaine;

    /**
     * @var integer
     */
    private $codedomaine;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Entreprises", mappedBy="codeDomaine")
     */
    private $codeentreprise;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->codeentreprise = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nomdomaine
     *
     * @param string $nomdomaine
     *
     * @return Domaineactivite
     */
    public function setNomdomaine($nomdomaine)
    {
        $this->nomdomaine = $nomdomaine;

        return $this;
    }

    /**
     * Get nomdomaine
     *
     * @return string
     */
    public function getNomdomaine()
    {
        return $this->nomdomaine;
    }

    /**
     * Get codedomaine
     *
     * @return integer
     */
    public function getCodedomaine()
    {
        return $this->codedomaine;
    }

    /**
     * Add codeentreprise
     *
     * @param \AppBundle\Entity\Entreprises $codeentreprise
     *
     * @return Domaineactivite
     */
    public function addCodeentreprise(\AppBundle\Entity\Entreprises $codeentreprise)
    {
        $this->codeentreprise[] = $codeentreprise;

        return $this;
    }

    /**
     * Remove codeentreprise
     *
     * @param \AppBundle\Entity\Entreprises $codeentreprise
     */
    public function removeCodeentreprise(\AppBundle\Entity\Entreprises $codeentreprise)
    {
        $this->codeentreprise->removeElement($codeentreprise);
    }

    /**
     * Get codeentreprise
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCodeentreprise()
    {
        return $this->codeentreprise;
    }
}

