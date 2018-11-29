<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Classes
 *
 * @ORM\Table(name="classes")
 * @ORM\Entity
 * @UniqueEntity(fields="nomclasse", message="Une classe existant possède déjà ce nom.")
 */
class Classes
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomClasse", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le nom de la classe doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $nomclasse;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1024, nullable=false)
     *
     * @Assert\NotBlank(message="La description est obligatoire.")
     * @Assert\Length(
     *     max = 1024,
     *     maxMessage = "La description de la classe doit faire au maximum {{ limit }} caractères."
     * )
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
    /**
     * @var \DateTime
     */
    private $dateDebStage;

    /**
     * @var \DateTime
     */
    private $dateFinStage;


    /**
     * Set dateDebStage
     *
     * @param \DateTime $dateDebStage
     *
     * @return Classes
     */
    public function setDateDebStage($dateDebStage)
    {
        $this->dateDebStage = $dateDebStage;

        return $this;
    }

    /**
     * Get dateDebStage
     *
     * @return \DateTime
     */
    public function getDateDebStage()
    {
        return $this->dateDebStage;
    }

    /**
     * Set dateFinStage
     *
     * @param \DateTime $dateFinStage
     *
     * @return Classes
     */
    public function setDateFinStage($dateFinStage)
    {
        $this->dateFinStage = $dateFinStage;

        return $this;
    }

    /**
     * Get dateFinStage
     *
     * @return \DateTime
     */
    public function getDateFinStage()
    {
        return $this->dateFinStage;
    }
}
