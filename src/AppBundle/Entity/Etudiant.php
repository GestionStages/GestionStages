<?php

namespace AppBundle\Entity;

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
     * @ORM\Column(name="nomEtudiant", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le nom de famille est obligatoire", groups={"edit"})
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le nom de famille doit faire au maximum 255 caractères",
     *     groups={"edit"}
     * )
     */
    private $nomEtudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomEtudiant", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le prénom est obligatoire", groups={"edit"})
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le prénom doit faire au maximum 255 caractères",
     *     groups={"edit"}
     * )
     */
    private $prenomEtudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="mailEtudiant", type="string", length=1024, nullable=false)
     * @Assert\NotBlank(message="L'email est obligatoire", groups={"edit"})
     * @Assert\Length(
     *     max="1024",
     *     maxMessage="L'email doit faire au maximum 1024 caractères",
     *     groups={"edit"}
     * )
     */
    private $mailEtudiant;

    /**
     * @var string
     * @ORM\Column(name="telEtudiant", type="string", length=10, nullable=false)
     *
     * @Assert\NotBlank(message="Le téléphone est obligatoire")
     * @Assert\Regex(
     *     pattern= "#^[0-9]{10,10}$#",
     *     match=true,
     *     message= "Le format du numéro n'est pas respecté."
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
     * @Assert\NotBlank(message="La classe est obligatoire")
     */
    private $codeclasse;

    /**
     * @var string
     * @ORM\Column(name="userEtudiant", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le nom d'utilisateur est obligatoire")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le nom d'utilisateur doit faire maximum 255 caractères"
     * )
     */
    private $userEtudiant;

    /**
     * @var string
     * @ORM\Column(name="passEtudiant", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le mot de passe est obligatoire", groups={"inscription"})
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le mot de passe doit faire maximum 255 caractères",
     *     groups={"inscription"}
     * )
     */
    private $passEtudiant;

    /**
     * @var string
     * @Assert\EqualTo(
     *     propertyPath="passEtudiant",
     *     message="Vous devez saisir le même mot de passe",
     *     groups={"edit"}
     * )
     */
    private $confirmPassEtudiant;

    /**
     * @return string
     */
    public function getPassEtudiant()
    {
        return $this->passEtudiant;
    }

    /**
     * @param string $passEtudiant
     */
    public function setPassEtudiant($passEtudiant)
    {
        $this->passEtudiant = $passEtudiant;
    }

    /**
     * @var string
     * @ORM\Column(name="numEtudiant", type="string", length=11, nullable=false)
     *
     * @Assert\NotBlank(message="Le numéro étudiant est obligatoire")
     * @Assert\Regex(
     *     pattern= "#^(\d{9}\D{2}|\d{10}\D{1})$#",
     *     match=true,
     *     message= "Le format du numéro n'est pas respecté."
     * )
     */
    private $numEtudiant;

    /**
     * @var string
     * @ORM\Column(name="addrEtudiant", type="string", length=1024, nullable=false)
     *
     * @Assert\NotBlank(message="L'adresse est obligatoire")
     * @Assert\Length(
     *     max="1024",
     *     maxMessage="L'adresse doit faire au maximum 1024 caractères"
     * )
     */
    private $addrEtudiant;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="La date de naissance est obligatoire")
     */
    private $dateEtudiant;

    /**
     * @var string
     * @ORM\Column(name="sexeEtudiant", type="string", length=1, nullable=false)
     *
     * @Assert\NotBlank(message="Le sexe est obligatoire")
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
        return $this->passEtudiant;
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

    /**
     * @return string
     */
    public function getConfirmPassEtudiant()
    {
        return $this->confirmPassEtudiant;
    }

    /**
     * @param string $confirmPassEtudiant
     */
    public function setConfirmPassEtudiant($confirmPassEtudiant)
    {
        $this->confirmPassEtudiant = $confirmPassEtudiant;
    }

    public function getNom()
    {
        return $this->nomEtudiant;
    }

    public function getPrenom()
    {
        return $this->prenomEtudiant;
    }

    public function getMail()
    {
        return $this->mailEtudiant;
    }

    public function getTel()
    {
        return $this->telEtudiant;
    }
}
