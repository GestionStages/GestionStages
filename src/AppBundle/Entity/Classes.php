<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Classes
 *
 * @ORM\Table(name="classes")
 * @ORM\Entity
 */
class Classes
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomClasse", type="string", length=30, nullable=false)
     *
     * @Assert\NotBlank(message="Le nom est obligatoire")
     */
    private $nomclasse;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=50, nullable=false)
     *
     * @Assert\NotBlank(message="La description est obligatoire")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="codeClasse", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeclasse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Propositions", mappedBy="codeclasse")
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
     * Set description
     *
     * @param string $description
     * @return Classes
     */
    public function setdescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
 * Set nomclasse
 *
 * @param string $nomclasse
 *
 * @return Classes
 */
    public function setNomclasse($nomclasse)
    {
        $this->nomclasse = $nomclasse;

        return $this;
    }

    /**
     * Get nomclasse
     *
     * @return string
     */
    public function getNomclasse()
    {
        return $this->nomclasse;
    }

    /**
     * Get codeclasse
     *
     * @return integer
     */
    public function getCodeclasse()
    {
        return $this->codeclasse;
    }

    /**
     * Add codeproposition
     *
     * @param \AppBundle\Entity\Propositions $codeproposition
     *
     * @return Classes
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
