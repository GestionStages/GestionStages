<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Technologies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Technology controller.
 *
 * @Route("technologies")
 */
class TechnologiesController extends Controller
{
    /**
     * Lists all technology entities.
     *
     * @Route("/", name="technologies_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $technologies = $em->getRepository('AppBundle:Technologies')->findAll();

        return $this->render('technologies/index.html.twig', array(
            'technologies' => $technologies,
        ));
    }

    /**
     * Creates a new technology entity.
     *
     * @Route("/new", name="technologies_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $technology = new Technology();
        $form = $this->createForm('AppBundle\Form\TechnologiesType', $technology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($technology);
            $em->flush();

            return $this->redirectToRoute('technologies_show', array('codetechnologie' => $technology->getCodetechnologie()));
        }

        return $this->render('technologies/new.html.twig', array(
            'technology' => $technology,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a technology entity.
     *
     * @Route("/{codetechnologie}", name="technologies_show")
     * @Method("GET")
     */
    public function showAction(Technologies $technology)
    {
        $deleteForm = $this->createDeleteForm($technology);

        return $this->render('technologies/show.html.twig', array(
            'technology' => $technology,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing technology entity.
     *
     * @Route("/{codetechnologie}/edit", name="technologies_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Technologies $technology)
    {
        $deleteForm = $this->createDeleteForm($technology);
        $editForm = $this->createForm('AppBundle\Form\TechnologiesType', $technology);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('technologies_edit', array('codetechnologie' => $technology->getCodetechnologie()));
        }

        return $this->render('technologies/edit.html.twig', array(
            'technology' => $technology,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a technology entity.
     *
     * @Route("/{codetechnologie}", name="technologies_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Technologies $technology)
    {
        $form = $this->createDeleteForm($technology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($technology);
            $em->flush();
        }

        return $this->redirectToRoute('technologies_index');
    }

    /**
     * Creates a form to delete a technology entity.
     *
     * @param Technologies $technology The technology entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Technologies $technology)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('technologies_delete', array('codetechnologie' => $technology->getCodetechnologie())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

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
