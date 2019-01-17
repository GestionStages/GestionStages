<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Professeur
 *
 * @ORM\Table(name="professeur")
 * @ORM\Entity
 */
class Professeur implements UserInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nomProf", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le nom de famille est obligatoire", groups={"edit"})
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le nom de famille doit faire au maximum 255 caractères",
     *     groups={"edit"}
     * )
     */
    private $nomProf;

    /**
     * @var string
     * @ORM\Column(name="prenomProf", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le prénom est obligatoire", groups={"edit"})
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le prénom doit faire au maximum 255 caractères",
     *     groups={"edit"}
     * )
     */
    private $prenomProf;

    /**
     * @var string
     * @ORM\Column(name="mailProf", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="L'email est obligatoire", groups={"edit"})
     * @Assert\Length(
     *     max="1024",
     *     maxMessage="L'email doit faire au maximum 1024 caractères",
     *     groups={"edit"}
     * )
     */
    private $mailProf;

    /**
     * @var string
     * @ORM\Column(name="telProf", type="string", length=10, nullable=false)
     *
     * @Assert\NotBlank(message="Le téléphone est obligatoire")
     * @Assert\Regex(
     *     pattern= "#^[0-9]{10,10}$#",
     *     match=true,
     *     message= "Le format du numéro n'est pas respecté."
     * )
     */
    private $telProf;

    /**
     * @var string
     * @ORM\Column(name="userProf", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le nom d'utilisateur est obligatoire")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le nom d'utilisateur doit faire maximum 255 caractères"
     * )
     */
    private $userProf;

    /**
     * @return string
     */
    public function getUserProf()
    {
        return $this->userProf;
    }

    /**
     * @param string $userProf
     */
    public function setUserProf($userProf)
    {
        $this->userProf = $userProf;
    }

    /**
     * @var string
     * @ORM\Column(name="passProf", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le mot de passe est obligatoire", groups={"inscription"})
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le mot de passe doit faire maximum 255 caractères",
     *     groups={"inscription"}
     * )
     */
    private $passProf;

    /**
     * @var string
     * @Assert\EqualTo(
     *     propertyPath="passProf",
     *     message="Vous devez saisir le même mot de passe",
     *     groups={"edit"}
     * )
     */
    private $confirmPassProf;

    /**
     * @return string
     */
    public function getPassProf()
    {
        return $this->passProf;
    }

    /**
     * @param string $passProf
     */
    public function setPassProf($passProf)
    {
        $this->passProf = $passProf;
    }

    /**
     * @var \AppBundle\Entity\RolesProf
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RolesProf")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codeRole", referencedColumnName="codeRole", nullable=false)
     * })
     */
    private $roleProf;

    /**
     * @return mixed
     */
    public function getRoleProf()
    {
        return $this->roleProf;
    }

    /**
     * @param mixed $roleProf
     */
    public function setRoleProf($roleProf)
    {
        $this->roleProf = $roleProf;
    }

    /**
     * @return string
     */
    public function getTelProf()
    {
        return $this->telProf;
    }

    /**
     * @param string $telProf
     */
    public function setTelProf($telProf)
    {
        $this->telProf = $telProf;
    }


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

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $roles = ['ROLE_PROF'];
        if (!is_null($this->roleProf->getNomRole())) {
            $roles[] = $this->roleProf->getNomRole();
        }

        return $roles;
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
        return $this->passProf;
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
        return $this->userProf;
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
    public function getConfirmPassProf()
    {
        return $this->confirmPassProf;
    }

    /**
     * @param string $confirmPassProf
     */
    public function setConfirmPassProf($confirmPassProf)
    {
        $this->confirmPassProf = $confirmPassProf;
    }

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Propositions", mappedBy="codeProfesseur")
     */
    private $propositions;

    /**
     * Professeur constructor.
     */
    public function __construct()
    {
        $this->propositions = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPropositions()
    {
        return $this->propositions;
    }

    /**
     * @param Propositions $proposition
     */
    public function addProposition(Propositions $proposition) {
        $this->propositions[] = $proposition;
    }

    public function removeProposition(Propositions $proposition) {
        $this->propositions->removeElement($proposition);
    }
}
