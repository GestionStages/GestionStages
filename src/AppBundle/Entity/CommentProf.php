<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentProf
 *
 * @ORM\Table(name="comment_prof")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentProfRepository")
 */
class CommentProf
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
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Professeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prof", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $prof;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Propositions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proposition", referencedColumnName="codeProposition", nullable=false, onDelete="CASCADE")
     * })
     */
    private $proposition;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set prof
     *
     * @param integer $prof
     *
     * @return CommentProf
     */
    public function setProf($prof)
    {
        $this->prof = $prof;

        return $this;
    }

    /**
     * Get prof
     *
     * @return int
     */
    public function getProf()
    {
        return $this->prof;
    }

    /**
     * Set proposition
     *
     * @param integer $proposition
     *
     * @return CommentProf
     */
    public function setProposition($proposition)
    {
        $this->proposition = $proposition;

        return $this;
    }

    /**
     * Get proposition
     *
     * @return int
     */
    public function getProposition()
    {
        return $this->proposition;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return CommentProf
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CommentProf
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

