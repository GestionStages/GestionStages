<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Properties
 *
 * @ORM\Table(name="properties")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropertiesRepository")
 */
class Properties
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="planning_startdate", type="date")
     * @Assert\Date(message="La valeur doit être une date valide", groups={"horaires_soutenance"})
     */
    private $planning_startdate;

    /**
     * @ORM\Column(name="planning_enddate", type="date")
     * @Assert\Date(message="La valeur doit être une date valide", groups={"horaires_soutenance"})
     * @Assert\GreaterThan(
     *     propertyPath="planning_startdate",
     *     message="La date de fin doit être supérieure à celle de début",
     *     groups={"horaires_soutenance"}
     * )
     */
    private $planning_enddate;

    /**
     * @ORM\Column(name="planning_starthourAm", type="time")
     * @Assert\Time(message="La valeur doit être une heure valide", groups={"horaires_soutenance"})
     */
    private $planning_starthourAm;

    /**
     * @ORM\Column(name="planning_endhourAm", type="time")
     * @Assert\Time(message="La valeur doit être une heure valide")
     * @Assert\GreaterThan(
     *     propertyPath="planning_starthourAm",
     *     message="L'heure de fin doit être supérieure à celle de début",
     *     groups={"horaires_soutenance"}
     * )
     */
    private $planning_endhourAm;

    /**
     * @ORM\Column(name="planning_starthourPm", type="time")
     * @Assert\Time(message="La valeur doit être une heure valide")
     * @Assert\GreaterThan(
     *     propertyPath="planning_endhourAm",
     *     message="L'heure de reprise doit être supérieure à celle de fin du matin",
     *     groups={"horaires_soutenance"}
     * )
     */
    private $planning_starthourPm;

    /**
     * @ORM\Column(name="planning_endhourPm", type="time")
     * @Assert\Time(message="La valeur doit être une heure valide")
     * @Assert\GreaterThan(
     *     propertyPath="planning_starthourPm",
     *     message="L'heure de fin doit être supérieure à celle de début",
     *     groups={"horaires_soutenance"}
     * )
     */
    private $planning_endhourPm;

    /**
     * @ORM\Column(name="planning_timeinterval", type="integer")
     * @Assert\GreaterThan(value="0", message="La valeur ne peut être inférieure à 0", groups={"horaires_soutenance"})
     */
    private $planning_timeinterval;

    /**
     * @ORM\Column(name="home_title", type="string", length=1024)
     * @Assert\Length(
     *     max="1024",
     *     maxMessage="Le titre ne peut dépasser 1024 caractères",
     *     groups={"infosGenerales"}
     * )
     */
    private $home_title;

    /**
     * @ORM\Column(name="home_text", type="text")
     */
    private $home_text;

    /**
     * @return mixed
     */
    public function getPlanningStartdate()
    {
        return $this->planning_startdate;
    }

    /**
     * @param mixed $planning_startdate
     */
    public function setPlanningStartdate($planning_startdate)
    {
        $this->planning_startdate = $planning_startdate;
    }

    /**
     * @return mixed
     */
    public function getPlanningEnddate()
    {
        return $this->planning_enddate;
    }

    /**
     * @param mixed $planning_enddate
     */
    public function setPlanningEnddate($planning_enddate)
    {
        $this->planning_enddate = $planning_enddate;
    }

    /**
     * @return mixed
     */
    public function getPlanningStarthourAm()
    {
        return $this->planning_starthourAm;
    }

    /**
     * @param mixed $planning_starthourAm
     */
    public function setPlanningStarthourAm($planning_starthourAm)
    {
        $this->planning_starthourAm = $planning_starthourAm;
    }

    /**
     * @return mixed
     */
    public function getPlanningEndhourAm()
    {
        return $this->planning_endhourAm;
    }

    /**
     * @param mixed $planning_endhourAm
     */
    public function setPlanningEndhourAm($planning_endhourAm)
    {
        $this->planning_endhourAm = $planning_endhourAm;
    }

    /**
     * @return mixed
     */
    public function getPlanningStarthourPm()
    {
        return $this->planning_starthourPm;
    }

    /**
     * @param mixed $planning_starthourPm
     */
    public function setPlanningStarthourPm($planning_starthourPm)
    {
        $this->planning_starthourPm = $planning_starthourPm;
    }

    /**
     * @return mixed
     */
    public function getPlanningEndhourPm()
    {
        return $this->planning_endhourPm;
    }

    /**
     * @param mixed $planning_endhourPm
     */
    public function setPlanningEndhourPm($planning_endhourPm)
    {
        $this->planning_endhourPm = $planning_endhourPm;
    }

    /**
     * @return mixed
     */
    public function getPlanningTimeinterval()
    {
        return $this->planning_timeinterval;
    }

    /**
     * @param mixed $planning_timeinterval
     */
    public function setPlanningTimeinterval($planning_timeinterval)
    {
        $this->planning_timeinterval = $planning_timeinterval;
    }

    /**
     * @return mixed
     */
    public function getHomeTitle()
    {
        return $this->home_title;
    }

    /**
     * @param mixed $home_title
     */
    public function setHomeTitle($home_title)
    {
        $this->home_title = $home_title;
    }

    /**
     * @return mixed
     */
    public function getHomeText()
    {
        return $this->home_text;
    }

    /**
     * @param mixed $home_text
     */
    public function setHomeText($home_text)
    {
        $this->home_text = $home_text;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

