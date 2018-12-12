<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Technologies
 *
 * @ORM\Table(name="technologies")
 * @ORM\Entity
 * @UniqueEntity(fields="nomtechnologie", message="Une technologie existante possède déjà ce nom.")
 */
class Technologies
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomTechnologie", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Le nom est obligatoire.")
     * @Assert\Length(
     *     max = 30,
     *     maxMessage = "Le nom doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $nomtechnologie;

    /**
     * @var integer
     *
     * @ORM\Column(name="codeTechnologie", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codetechnologie;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Propositions", inversedBy="codetechnologie")
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
     * Set nomtechnologie
     *
     * @param string $nomtechnologie
     *
     * @return Technologies
     */
    public function setNomtechnologie($nomtechnologie)
    {
        $this->nomtechnologie = $nomtechnologie;

        return $this;
    }

    /**
     * Get nomtechnologie
     *
     * @return string
     */
    public function getNomtechnologie()
    {
        return $this->nomtechnologie;
    }

    /**
     * Get codetechnologie
     *
     * @return integer
     */
    public function getCodetechnologie()
    {
        return $this->codetechnologie;
    }

    /**
     * Add codeproposition
     *
     * @param \AppBundle\Entity\Propositions $codeproposition
     *
     * @return Technologies
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
