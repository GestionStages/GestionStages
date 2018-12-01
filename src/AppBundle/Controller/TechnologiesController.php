<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Technologies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Technology controller.
 *
 * @Route("technologies")
 */
class TechnologiesController extends Controller
{

	/**
	 * @Route("/search")
	 * @param Request $request
	 * @return Response
	 */
	public function searchTechnologie(Request $request)
	{
		$q = $request->query->get('term');
		$results = $this->getDoctrine()->getRepository(Technologies::class)->findLikeName($q);

		return $this->render('technologies/list.json.twig', ['results' => $results]);
	}
}
