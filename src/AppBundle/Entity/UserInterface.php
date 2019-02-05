<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 26/01/19
 * Time: 19:53
 */

namespace AppBundle\Entity;


interface UserInterface extends \Symfony\Component\Security\Core\User\UserInterface
{
    public function getNom();

    public function getPrenom();

    public function getMail();

    public function getTel();
}