<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Domaineactivite
 * @ORM\Table(name="domaineactivite")
 * @ORM\Entity
 * @UniqueEntity(fields="nomdomaine", message="Un domaine d'activité existant possède déjà ce nom.")
 */
class Domaineactivite
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomDomaine", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message = "Le nom est obligatoire.")
     * @Assert\Length(
     *     min = 2,
     *     max = 50,
     *     minMessage = "Le nom du domaine d'activité doit faire au minimum {{ limit }} caractères.",
     *     maxMessage = "Le nom du domaine d'activité doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $nomdomaine;

    /**
     * @var integer
     * @ORM\Column(name="codeDomaine", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
