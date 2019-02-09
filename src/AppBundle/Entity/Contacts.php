<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contacts
 *
 * @ORM\Table(name="contacts", indexes={@ORM\Index(name="fk_codeEntreprise", columns={"codeEntreprise"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactsRepository")
 */
class Contacts implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomContact", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le nom est obligatoire.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le nom doit faire au maximum {{ limit }} caractères."
     * )
     *
     */
    private $nomcontact;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomContact", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le prénom est obligatoire.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le prénnom doit faire au maximum {{ limit }} caractères."
     * )
     *
     */
    private $prenomcontact;

    /**
     * @var string
     *
     * @ORM\Column(name="mailContact", type="string", length=1024, nullable=false)
     *
     * @Assert\NotBlank(message="Le mail est obligatoire.")
     * @Assert\Length(
     *     max = 1024,
     *     maxMessage = "L'adresse mail doit faire au maximum {{ limit }} caractères."
     * )
     * @Assert\Email(
     *     message= "L'adresse mail fournie est invalide !"
     * )
     */
    private $mailcontact;

    /**
     * @var string
     *
     * @ORM\Column(name="telContact", type="string", length=10, nullable=false)
     *
     * @Assert\NotBlank(message="Le téléphone est obligatoire.")
     * @Assert\Regex(
     *      pattern= "#^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$#",
     *     match=true,
     *     message= "Le format du numéro de téléphone n'est pas respecté"
     * )
     */
    private $telcontact;

    /**
     * @var integer
     *
     * @ORM\Column(name="codeContact", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codecontact;

    /**
     * @var \AppBundle\Entity\Entreprises
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Entreprises")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codeEntreprise", referencedColumnName="codeEntreprise", nullable=false, onDelete="CASCADE")
     * })
     *
     * @Assert\NotBlank(message="L'entreprise est obligatoire.")
     */
    private $codeentreprise;

    /**
     * Set nomcontact
     *
     * @param string $nomcontact
     *
     * @return Contacts
     */
    public function setNomcontact($nomcontact)
    {
        $this->nomcontact = $nomcontact;

        return $this;
    }

    /**
     * Get nomcontact
     *
     * @return string
     */
    public function getNomcontact()
    {
        return $this->nomcontact;
    }

    /**
     * Set prenomcontact
     *
     * @param string $prenomcontact
     *
     * @return Contacts
     */
    public function setPrenomcontact($prenomcontact)
    {
        $this->prenomcontact = $prenomcontact;

        return $this;
    }

    /**
     * Get prenomcontact
     *
     * @return string
     */
    public function getPrenomcontact()
    {
        return $this->prenomcontact;
    }

    /**
     * Set mailcontact
     *
     * @param string $mailcontact
     *
     * @return Contacts
     */
    public function setMailcontact($mailcontact)
    {
        $this->mailcontact = $mailcontact;

        return $this;
    }

    /**
     * Get mailcontact
     *
     * @return string
     */
    public function getMailcontact()
    {
        return $this->mailcontact;
    }

    /**
     * Set telcontact
     *
     * @param string $telcontact
     *
     * @return Contacts
     */
    public function setTelcontact($telcontact)
    {
        $this->telcontact = $telcontact;

        return $this;
    }

    /**
     * Get telcontact
     *
     * @return string
     */
    public function getTelcontact()
    {
        return $this->telcontact;
    }

    /**
     * Get codecontact
     *
     * @return integer
     */
    public function getCodecontact()
    {
        return $this->codecontact;
    }

    /**
     * Set codeentreprise
     *
     * @param \AppBundle\Entity\Entreprises $codeentreprise
     *
     * @return Contacts
     */
    public function setCodeentreprise(\AppBundle\Entity\Entreprises $codeentreprise)
    {
        $this->codeentreprise = $codeentreprise;

        return $this;
    }

    /**
     * Get codeentreprise
     *
     * @return \AppBundle\Entity\Entreprises
     */
    public function getCodeentreprise()
    {
        return $this->codeentreprise;
    }

    /**
     * @var string
     * @ORM\Column(name="posteContact", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Le poste dans l'entreprise est obligatoire.")
     */
    private $postecontact;


    /**
     * Set postecontact
     *
     * @param string $postecontact
     *
     * @return Contacts
     */
    public function setPostecontact($postecontact)
    {
        $this->postecontact = $postecontact;

        return $this;
    }

    /**
     * Get postecontact
     *
     * @return string
     */
    public function getPostecontact()
    {
        return $this->postecontact;
    }
    /**
     * @var string
     * @ORM\Column(name="mdpContact", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le mot de passe est obligatoire.",groups={"inscription"})
     * @Assert\Length(
     *     min = 8,
     *     minMessage = "Le mot de passe doit faire au minimum {{ limit }} caractères.",
     *     groups={"inscription"}
     *     )
     *
     */
    private $mdpcontact;


    /**
     * Set mdpcontact
     *
     * @param string $mdpcontact
     *
     * @return Contacts
     */
    public function setMdpcontact($mdpcontact)
    {
        $this->mdpcontact = $mdpcontact;

        return $this;
    }

    /**
     * Get mdpcontact
     *
     * @return string
     */
    public function getMdpcontact()
    {
        return $this->mdpcontact;
    }

    /**
     * @var string
     * @ORM\Column(name="userContact", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le nom d'utilisateur est obligatoire.")
     */
    private $userContact;

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
        return ['ROLE_ENTREPRISE'];
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
        return $this->getMdpcontact();
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
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {}

    /**
     * @return mixed
     */
    public function getUserContact()
    {
        return $this->userContact;
    }

    /**
     * @param mixed $userContact
     */
    public function setUserContact($userContact)
    {
        $this->userContact = $userContact;
    }


    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getUserContact();
    }

    public function getNom()
    {
        return $this->nomcontact;
    }

    public function getPrenom()
    {
        return $this->prenomcontact;
    }

    public function getMail()
    {
        return $this->mailcontact;
    }

    public function getTel()
    {
        return $this->telcontact;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="codeInscription", type="string", length=200, nullable=true)
     */
    private $codeInscription;


    /**
     * Set codeInscription
     *
     * @param string $codeInscription
     *
     * @return Contacts
     */
    public function setCodeInscription($codeInscription)
    {
        $this->codeInscription = $codeInscription;

        return $this;
    }

    /**
     * Get codeInscription
     *
     * @return string
     */
    public function getCodeInscription()
    {
        return $this->codeInscription;
    }

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Propositions", inversedBy=""
     */
    private $propositionsTuteur;

    /**
     * Contacts constructor.
     * @param $propositionsTuteur
     */
    public function __construct()
    {
        $this->propositionsTuteur = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPropositionsTuteur()
    {
        return $this->propositionsTuteur;
    }

    /**
     * @param mixed $propositionsTuteur
     */
    public function addPropositionTuteur($propositionsTuteur)
    {
        $this->propositionsTuteur[] = $propositionsTuteur;
    }

    /**
     * @param mixed $propositionsTuteur
     */
    public function removePropositionTuteur($propositionsTuteur)
    {
        $this->propositionsTuteur->removeElement($propositionsTuteur);
    }
}
