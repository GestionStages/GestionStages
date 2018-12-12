<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiants")
 * @ORM\Entity
 * @UniqueEntity(fields="nomentreprise", message="Une entreprise existante possède déjà ce nom.")
 */
class Etudiant
{
    /**
     *
     * @var int
     */
    private $id;

    /**
     * @var string
     *
     *
     *
     * @ORM\Column(name="nomEtudiant", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le nom est obligatoire.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le nom doit faire au maximum {{ limit }} caractères."
     * )
     *
     */
    private $nomEtudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomEtudiant", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le prenom est obligatoire.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le prenom doit faire au maximum {{ limit }} caractères."
     * )
     *
     */
    private $prenomEtudiant;

    /**
     * @var string
     * @ORM\Column(name="mailEtudiant", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le mail est obligatoire.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le mail doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $mailEtudiant;
    /**
     * @var string
     * @ORM\Column(name="telEtudiant", type="string", length=10, nullable=false)
     *
     * @Assert\NotBlank(message="Le téléphone est obligatoire.")
     * @Assert\Length(
     *     max = 10,
     *     maxMessage = "Le mail doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $telEtudiant;


    /**
     * @var \AppBundle\Entity\Propositions
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Propositions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codeProposition", referencedColumnName="codeProposition", nullable=true)
     * })
     *
     */
    private $codeproposition;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomEtudiant
     *
     * @param string $nomEtudiant
     *
     * @return Etudiant
     */
    public function setNomEtudiant($nomEtudiant)
    {
        $this->nomEtudiant = $nomEtudiant;

        return $this;
    }

    /**
     * Get nomEtudiant
     *
     * @return string
     */
    public function getNomEtudiant()
    {
        return $this->nomEtudiant;
    }

    /**
     * Set prenomEtudiant
     *
     * @param string $prenomEtudiant
     *
     * @return Etudiant
     */
    public function setPrenomEtudiant($prenomEtudiant)
    {
        $this->prenomEtudiant = $prenomEtudiant;

        return $this;
    }

    /**
     * Get prenomEtudiant
     *
     * @return string
     */
    public function getPrenomEtudiant()
    {
        return $this->prenomEtudiant;
    }

    /**
     * Set mailEtudiant
     *
     * @param string $mailEtudiant
     *
     * @return Etudiant
     */
    public function setMailEtudiant($mailEtudiant)
    {
        $this->mailEtudiant = $mailEtudiant;

        return $this;
    }

    /**
     * Get mailEtudiant
     *
     * @return string
     */
    public function getMailEtudiant()
    {
        return $this->mailEtudiant;
    }

    /**
     * Set telEtudiant
     *
     * @param string $telEtudiant
     *
     * @return Etudiant
     */
    public function setTelEtudiant($telEtudiant)
    {
        $this->telEtudiant = $telEtudiant;

        return $this;
    }

    /**
     * Get telEtudiant
     *
     * @return string
     */
    public function getTelEtudiant()
    {
        return $this->telEtudiant;
    }
    /**
     * @var integer
     */
    private $codeEtudiant;

    /**
     * @var \AppBundle\Entity\Propositions
     */
    private $codeProposition;


    /**
     * Get codeEtudiant
     *
     * @return integer
     */
    public function getCodeEtudiant()
    {
        return $this->codeEtudiant;
    }

    /**
     * Set codeProposition
     *
     * @param \AppBundle\Entity\Propositions $codeProposition
     *
     * @return Etudiant
     */
    public function setCodeProposition(\AppBundle\Entity\Propositions $codeProposition = null)
    {
        $this->codeProposition = $codeProposition;

        return $this;
    }

    /**
     * Get codeProposition
     *
     * @return \AppBundle\Entity\Propositions
     */
    public function getCodeProposition()
    {
        return $this->codeProposition;
    }
}
