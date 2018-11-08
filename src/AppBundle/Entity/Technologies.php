<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Technologies
 *
 * @ORM\Table(name="technologies")
 * @ORM\Entity
 */
class Technologies
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomTechnologie", type="string", length=30, nullable=false)
     */
    private $nomtechnologie;

    /**
     * @var integer
     *
     * @ORM\Column(name="codeTechnololgie", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codetechnololgie;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Propositions", inversedBy="codetechnololgie")
     */
    private $codeproposition;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->codeproposition = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nomtechnologie
     *
     * @param string $nomtechnologie
     *
     * @return Technologies
     */
    public function setNomtechnologie($nomtechnologie)
    {
        $this->nomtechnologie = $nomtechnologie;

        return $this;
    }

    /**
     * Get nomtechnologie
     *
     * @return string
     */
    public function getNomtechnologie()
    {
        return $this->nomtechnologie;
    }

    /**
     * Get codetechnololgie
     *
     * @return integer
     */
    public function getCodetechnololgie()
    {
        return $this->codetechnololgie;
    }

    /**
     * Add codeproposition
     *
     * @param \AppBundle\Entity\Propositions $codeproposition
     *
     * @return Technologies
     */
    public function addCodeproposition(\AppBundle\Entity\Propositions $codeproposition)
    {
        $this->codeproposition[] = $codeproposition;

        return $this;
    }

    /**
     * Remove codeproposition
     *
     * @param \AppBundle\Entity\Propositions $codeproposition
     */
    public function removeCodeproposition(\AppBundle\Entity\Propositions $codeproposition)
    {
        $this->codeproposition->removeElement($codeproposition);
    }

    /**
     * Get codeproposition
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCodeproposition()
    {
        return $this->codeproposition;
    }
}
