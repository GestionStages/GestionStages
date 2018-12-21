<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiants")
 * @ORM\Entity
 */
class Etudiant implements UserInterface
{
    /**
     *
     * @var int
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEtudiant", type="string", length=255, nullable=false)     *
     */
    private $nomEtudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomEtudiant", type="string", length=255, nullable=false)
     */
    private $prenomEtudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="mailEtudiant", type="string", length=255, nullable=false)
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
     * Get codeEtudiant
     *
     * @return integer
     */
    public function getCodeEtudiant()
    {
        return $this->codeEtudiant;
    }

    /**
     * @var \AppBundle\Entity\Classes
     */
    private $codeclasse;

    /**
     * @var string
     * @ORM\Column(name="userEtudiant", type="string", length=255, nullable=false)
     */
    private $userEtudiant;

    /**
     * @var string
     * @ORM\Column(name="numEtudiant", type="string", length=8, nullable=false)
     *
     * @Assert\Regex(
     *     pattern= "#^[0-9]{8,8}$#",
     *     match=true,
     *     message= "Le format du numéro n'est pas respecté."
     * )
     */
    private $numEtudiant;

    /**
     * @var string
     * @ORM\Column(name="addrEtudiant", type="string", length=1024, nullable=false)
     *
     * @Assert\Length(
     *     max="1024",
     *     maxMessage="L'addresse doit faire au maximum 1024 caractères"
     * )
     */
    private $addrEtudiant;

    /**
     * @var \DateTime
     */
    private $dateEtudiant;

    /**
     * @var string
     * @ORM\Column(name="sexeEtudiant", type="string", length=1, nullable=false)
     *
     * @Assert\Choice(
     *     choices={"h","f","o"},
     *     message="Vous devez sélectionner un genre valide"
     * )
     */
    private $sexeEtudiant;

    /**
     * @return string
     */
    public function getUserEtudiant()
    {
        return $this->userEtudiant;
    }

    /**
     * @param string $userEtudiant
     */
    public function setUserEtudiant($userEtudiant)
    {
        $this->userEtudiant = $userEtudiant;
    }

    /**
     * @return string
     */
    public function getNumEtudiant()
    {
        return $this->numEtudiant;
    }

    /**
     * @param string $numEtudiant
     */
    public function setNumEtudiant($numEtudiant)
    {
        $this->numEtudiant = $numEtudiant;
    }

    /**
     * @return string
     */
    public function getAddrEtudiant()
    {
        return $this->addrEtudiant;
    }

    /**
     * @param string $addrEtudiant
     */
    public function setAddrEtudiant($addrEtudiant)
    {
        $this->addrEtudiant = $addrEtudiant;
    }

    /**
     * @return string
     */
    public function getDateEtudiant()
    {
        return $this->dateEtudiant;
    }

    /**
     * @param string $dateEtudiant
     */
    public function setDateEtudiant($dateEtudiant)
    {
        $this->dateEtudiant = $dateEtudiant;
    }

    /**
     * @return string
     */
    public function getSexeEtudiant()
    {
        return $this->sexeEtudiant;
    }

    /**
     * @param string $sexeEtudiant
     */
    public function setSexeEtudiant($sexeEtudiant)
    {
        $this->sexeEtudiant = $sexeEtudiant;
    }

    /**
     * @return Classes
     */
    public function getCodeclasse()
    {
        return $this->codeclasse;
    }

    /**
     * @param Classes $codeclasse
     */
    public function setCodeclasse($codeclasse)
    {
        $this->codeclasse = $codeclasse;
    }

    public function getRoles() {
        return ['ROLE_STUDENT'];
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->userEtudiant;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {}
}
