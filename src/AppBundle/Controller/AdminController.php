<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Propositions;
use AppBundle\Entity\Etat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="showAdminHome")
     */
    public function showHome()
    {
        return $this->render('admin/home.html.twig');
    }

    /**
     * @Route("/admin/list", name="showAdminListAll")
     */
    public function showListAll()
    {
        $repository = $this->getDoctrine()->getRepository(Propositions::class);

        $query = $repository->createQueryBuilder('p')
            ->orderBy('p.dateajout', 'DESC')
            ->getQuery();

        $propositions = $query->getResult();

        return $this->render('admin/list.html.twig',['propositions' => $propositions]);
    }

    /**
     * @Route("/admin/valid/{id}", name="validProposition", requirements={"id"="\d+"})
     */
    public function approve($id)
    {
        $em = $this->getDoctrine()->getManager();

        $etat = $this->getDoctrine()
            ->getRepository('AppBundle:Etat')
            ->find(2);

        $em->getRepository('AppBundle:Propositions')
            ->find($id)
            ->setCodeetat($etat);

        $em->flush();

        return $this->redirectToRoute('showAdminListAll');
    }

    /**
     * @Route("/admin/reject/{id}", name="rejectProposition", requirements={"id"="\d+"})
     */
    public function reject($id)
    {
        $em = $this->getDoctrine()->getManager();

        $etat = $this->getDoctrine()
            ->getRepository('AppBundle:Etat')
            ->find(5);

        $em->getRepository('AppBundle:Propositions')
            ->find($id)
            ->setCodeetat($etat);

        $em->flush();

        return $this->redirectToRoute('showAdminListAll');
    }

    /**
     * @Route("/admin/archive/{id}", name="archiveProposition", requirements={"id"="\d+"})
     */
    public function archive($id)
    {
        $em = $this->getDoctrine()->getManager();

        $etat = $this->getDoctrine()
            ->getRepository('AppBundle:Etat')
            ->find(4);

        $em->getRepository('AppBundle:Propositions')
            ->find($id)
            ->setCodeetat($etat);

        $em->flush();

        return $this->redirectToRoute('showAdminListAll');
    }
}
