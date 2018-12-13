<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class StagesController extends Controller
{
    /**
     * @Route("/stages/{id}/convention", name="generateconvention", requirements={"id"="\d+"})
     */
    public function conventionaction() {

    }
}
