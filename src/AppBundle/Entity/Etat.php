<?php

namespace AppBundle\Entity;

/**
 * Etat
 */
class Etat
{
    /**
     * @var string
     */
    private $nometat;

    /**
     * @var integer
     */
    private $codeetat;


    /**
     * Set nometat
     *
     * @param string $nometat
     *
     * @return Etat
     */
    public function setNometat($nometat)
    {
        $this->nometat = $nometat;

        return $this;
    }

    /**
     * Get nometat
     *
     * @return string
     */
    public function getNometat()
    {
        return $this->nometat;
    }

    /**
     * Get codeetat
     *
     * @return integer
     */
    public function getCodeetat()
    {
        return $this->codeetat;
    }
}
