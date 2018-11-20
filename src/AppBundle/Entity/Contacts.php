<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contacts
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity
 */
class Contacts
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomContact", type="string", length=30, nullable=false)
     *
     * @Assert\NotNull
     * @Assert\NotBlank(message="Le nom est obligatoire.")
     * @Assert\Length(
     *     min = 2,
     *     max = 30,
     *     minMessage = "Le nom doit faire au minimum {{ limit }} caractères.",
     *     maxMessage = "Le nom doit faire au maximum {{ limit }} caractères."
     * )
     *
     */
    private $nomcontact;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomContact", type="string", length=30, nullable=false)
     *
     * @Assert\NotNull
     * @Assert\NotBlank(message="Le prénom est obligatoire.")
     * @Assert\Length(
     *     min = 2,
     *     max = 30,
     *     minMessage = "Le prénom doit faire au minimum {{ limit }} caractères.",
     *     maxMessage = "Le prénnom doit faire au maximum {{ limit }} caractères."
     * )
     *
     */
    private $prenomcontact;

    /**
     * @var string
     *
     * @ORM\Column(name="mailContact", type="string", length=30, nullable=false)
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 2,
     *     max = 30,
     *     minMessage = "L'adresse mail doit faire au minimum {{ limit }} caractères.",
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
     * @Assert\NotNull
     * @Assert\NotBlank
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Entreprises", mappedBy="codecontact")
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
     * Add codeentreprise
     *
     * @param \AppBundle\Entity\Entreprises $codeentreprise
     *
     * @return Contacts
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
