<?php

	namespace AppBundle\Controller;

	use AppBundle\Entity\Classes;
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
			// replace this example code with whatever you need

            $repository = $this->getDoctrine()
                ->getRepository(Classes::class);

            $query = $repository->createQueryBuilder('c')
                ->getQuery();
            $classes = $query->getResult();

            return $this->render('home.html.twig',['classes' => $classes]);
		}

		/**
		 *@Route("/other", name="other")
		 */

		public function otherAction() {
			return $this->render('other.html.twig');
		}

	}

