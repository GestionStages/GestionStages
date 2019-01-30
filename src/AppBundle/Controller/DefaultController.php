<?php

	namespace AppBundle\Controller;

	use AppBundle\Entity\Classes;
    use AppBundle\Entity\Properties;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Routing\Annotation\Route;

	class DefaultController extends Controller
	{

		/**
		 * @Route("/", name="homepage")
		 */
		public function indexAction(Request $request)
		{
            $classes = $this->getDoctrine()
                            ->getRepository(Classes::class)
                            ->findAll();

            /** @var Properties $properties */
            $properties = $this->getDoctrine()->getRepository(Properties::class)->find(1);

            return $this->render('home.html.twig',[
                'classes' => $classes,
                'title' => $properties->getHomeTitle(),
                'text' => $properties->getHomeText()
            ]);
		}

		/**
		 *@Route("/other", name="other")
		 */

		public function otherAction() {
			return $this->render('other.html.twig');
		}

	}

