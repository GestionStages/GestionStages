<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Professeur
 *
 * @ORM\Table(name="professeur")
 * @ORM\Entity
 */
class Professeur
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nomProf", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le nom est obligatoire.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le nom doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $nomProf;

    /**
     * @var string
     * @ORM\Column(name="prenomProf", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le prenom est obligatoire.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le prenom doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $prenomProf;

    /**
     * @var string
     * @ORM\Column(name="mailProf", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le mail est obligatoire.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le mail doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $mailProf;


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
     * Set nomProf
     *
     * @param string $nomProf
     *
     * @return Professeur
     */
    public function setNomProf($nomProf)
    {
        $this->nomProf = $nomProf;

        return $this;
    }

    /**
     * Get nomProf
     *
     * @return string
     */
    public function getNomProf()
    {
        return $this->nomProf;
    }

    /**
     * Set prenomProf
     *
     * @param string $prenomProf
     *
     * @return Professeur
     */
    public function setPrenomProf($prenomProf)
    {
        $this->prenomProf = $prenomProf;

        return $this;
    }

    /**
     * Get prenomProf
     *
     * @return string
     */
    public function getPrenomProf()
    {
        return $this->prenomProf;
    }

    /**
     * Set mailProf
     *
     * @param string $mailProf
     *
     * @return Professeur
     */
    public function setMailProf($mailProf)
    {
        $this->mailProf = $mailProf;

        return $this;
    }

    /**
     * Get mailProf
     *
     * @return string
     */
    public function getMailProf()
    {
        return $this->mailProf;
    }
}
