<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Propositions
 *
 * @ORM\Table(name="propositions", indexes={@ORM\Index(name="fk_codeEntreprise", columns={"codeEntreprise"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropositionsRepository")
 */
class Propositions
{
    /**
     * @var string
     *
     * @ORM\Column(name="titreProposition", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Le titre est obligatoire.")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "Le titre doit faire au maximum {{ limit }} caractères."
     * )
     *
     */
    private $titreproposition;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionProposition", type="text", nullable=false)
     *
     * @Assert\NotBlank(message="La description est obligatoire.")
     */
    private $descriptionproposition;

    /**
     * @var integer
     *
     * @ORM\Column(name="codeProposition", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeproposition;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Classes", inversedBy="codeproposition")
     * @ORM\JoinTable(name="associerclassespropositions",
     *   joinColumns={
     *     @ORM\JoinColumn(name="codeProposition", referencedColumnName="codeProposition", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="codeClasse", referencedColumnName="codeClasse")
     *   }
     * )
     */
    private $codeclasse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Technologies", mappedBy="codeproposition")
     * @ORM\JoinTable(name="associertechnologiespropositions",
     *   joinColumns={
     *     @ORM\JoinColumn(name="codeProposition", referencedColumnName="codeProposition", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="codeTechnologie", referencedColumnName="codeTechnologie")
     *   }
     * )
     */
    private $codetechnologie;

    /**
     * @ORM\Column(name="file", type="string", length=1024, nullable=true)
     *
     * @Assert\File(
     *     maxSize="2M",
     *     maxSizeMessage="Le fichier dépasse la taille maximale autorisée ({{ limit }} {{ suffix }})",
     *     mimeTypes={ "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document" },
     *     mimeTypesMessage="Le format du fichier est invalide"
     * )
     */
    private $file;


    public function getFile() {
        return $this->file;
    }


    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->codeclasse = new \Doctrine\Common\Collections\ArrayCollection();
        $this->codetechnologie = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set titreproposition
     *
     * @param string $titreproposition
     *
     * @return Propositions
     */
    public function setTitreproposition($titreproposition)
    {
        $this->titreproposition = $titreproposition;

        return $this;
    }

    /**
     * Get titreproposition
     *
     * @return string
     */
    public function getTitreproposition()
    {
        return $this->titreproposition;
    }

    /**
     * Set descriptionproposition
     *
     * @param string $descriptionproposition
     *
     * @return Propositions
     */
    public function setDescriptionproposition($descriptionproposition)
    {
        $this->descriptionproposition = $descriptionproposition;

        return $this;
    }

    /**
     * Get descriptionproposition
     *
     * @return string
     */
    public function getDescriptionproposition()
    {
        return $this->descriptionproposition;
    }

    /**
     * Get codeproposition
     *
     * @return integer
     */
    public function getCodeproposition()
    {
        return $this->codeproposition;
    }

    /**
     * Set codeentreprise
     *
     * @param \AppBundle\Entity\Entreprises $codeentreprise
     *
     * @return Propositions
     */
    public function setCodeentreprise(\AppBundle\Entity\Entreprises $codeentreprise = null)
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
     * Add codeclasse
     *
     * @param \AppBundle\Entity\Classes $codeclasse
     *
     * @return Propositions
     */
    public function addCodeclasse(\AppBundle\Entity\Classes $codeclasse)
    {
        $this->codeclasse[] = $codeclasse;

        return $this;
    }

    /**
     * Remove codeclasse
     *
     * @param \AppBundle\Entity\Classes $codeclasse
     */
    public function removeCodeclasse(\AppBundle\Entity\Classes $codeclasse)
    {
        $this->codeclasse->removeElement($codeclasse);
    }

    /**
     * Get codeclasse
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCodeclasse()
    {
        return $this->codeclasse;
    }

    /**
     * Add codetechnologie
     *
     * @param \AppBundle\Entity\Technologies $codetechnologie
     *
     * @return Propositions
     */
    public function addCodetechnologie(\AppBundle\Entity\Technologies $codetechnologie)
    {
        $this->codetechnologie[] = $codetechnologie;

        return $this;
    }

    /**
     * Remove codetechnologie
     *
     * @param \AppBundle\Entity\Technologies $codetechnologie
     */
    public function removeCodetechnologie(\AppBundle\Entity\Technologies $codetechnologie)
    {
        $this->codetechnologie->removeElement($codetechnologie);
    }

    /**
     * Get codetechnologie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCodetechnologie()
    {
        return $this->codetechnologie;
    }

    /**
     * @var \DateTime
     * @ORM\Column(name="dateajout", type="datetime", nullable=false)
     */
    private $dateajout;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     *
     */
    private $commentaire;

    /**
     * @var \AppBundle\Entity\Etat
     */
    private $codeetat;


    /**
     * Set dateajout
     *
     * @param \DateTime $dateajout
     *
     * @return Propositions
     */
    public function setDateajout($dateajout)
    {
        $this->dateajout = $dateajout;

        return $this;
    }

    /**
     * Get dateajout
     *
     * @return \DateTime
     */
    public function getDateajout()
    {
        return $this->dateajout;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Propositions
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set codeetat
     *
     * @param \AppBundle\Entity\Etat $codeetat
     *
     * @return Propositions
     */
    public function setCodeetat(\AppBundle\Entity\Etat $codeetat = null)
    {
        $this->codeetat = $codeetat;

        return $this;
    }

    /**
     * Get codeetat
     *
     * @return \AppBundle\Entity\Etat
     */
    public function getCodeetat()
    {
        return $this->codeetat;
    }
    /**
     * @var \AppBundle\Entity\Etudiant
     */
    private $codeEtudiant;


    /**
     * Set codeEtudiant
     *
     * @param Etudiant $codeEtudiant
     *
     * @return Propositions
     */
    public function setCodeEtudiant(\AppBundle\Entity\Etudiant $codeEtudiant = null)
    {
        $this->codeEtudiant = $codeEtudiant;

        return $this;
    }

    /**
     * Get codeEtudiant
     *
     * @return Etudiant
     */
    public function getCodeEtudiant()
    {
        return $this->codeEtudiant;
    }
    /**
     * @var \AppBundle\Entity\Professeur
     */
    private $codeProfesseur;


    /**
     * Set codeProfesseur
     *
     * @param \AppBundle\Entity\Professeur $codeProfesseur
     *
     * @return Propositions
     */
    public function setCodeProfesseur(\AppBundle\Entity\Professeur $codeProfesseur = null)
    {
        $this->codeProfesseur = $codeProfesseur;

        return $this;
    }

    /**
     * Get codeProfesseur
     *
     * @return \AppBundle\Entity\Professeur
     */
    public function getCodeProfesseur()
    {
        return $this->codeProfesseur;
    }
}
