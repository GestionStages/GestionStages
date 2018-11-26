<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Propositions;
use AppBundle\Entity\Etat;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        return $this->render('admin/propositions/list.html.twig',['propositions' => $propositions]);
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

    /**
     * @Route("/admin/editinfosgenerales", name="editinfos")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function editInfosAction(Request $request) {
        $infos = $request->request->get('infos');
        $titre = $request->request->get('titre');
        // Si la valeur est null, le form n'as pas était validé
        if($infos != null and $titre != null)
        {
            // on ouvre le fichier infos en écrasant l'ancienne valeur (w+)
            $fichierInfos = fopen(realpath('../app/Resources/views/admin/infosGenerales/infoGenerales.html.twig'),'w+');
            // on ecrit la nouvelle valeur
            fwrite($fichierInfos, $infos);
            // on ferme le fichier
            fclose($fichierInfos);

            // on ouvre le fichier infos en écrasant l'ancienne valeur (w+)
            $fichierTitre = fopen(realpath('../app/Resources/views/admin/infosGenerales/titreInfoGenerales.html.twig'),'w+');
            // on ecrit la nouvelle valeur
            fwrite($fichierTitre, $titre);
            // on ferme le fichier
            fclose($fichierTitre);

            $this->get('session')->getFlashBag()->add('notice','Modification de l\'accueil enregistrée !');
            return $this->redirectToRoute('homepage');

        }
        return $this->render('admin/InfosGenerales/infoGeneralesEdit.html.twig', array('infos'=> file_get_contents(realpath('../app/Resources/views/admin/infosGenerales/infoGenerales.html.twig')),'titre'=> file_get_contents(realpath('../app/Resources/views/admin/infosGenerales/titreInfoGenerales.html.twig'))));
    }
}
