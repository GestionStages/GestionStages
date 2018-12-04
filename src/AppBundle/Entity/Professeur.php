<?php

namespace AppBundle\Entity;

/**
 * Professeur
 */
class Professeur
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nomProf;

    /**
     * @var string
     */
    private $prenomProf;

    /**
     * @var string
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
