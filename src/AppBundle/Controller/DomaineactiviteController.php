<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Domaineactivite;
use AppBundle\Form\DomaineactiviteType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DomaineactiviteController extends Controller

{
    /**
     * @Route("/admin/domaineactivite/add", name="addDomaineActivite")
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, ObjectManager $em)
    {
        //On crée un nouveau domaine d'activité
        $domaineactivite = new Domaineactivite();

        //On récupère le form
        $form = $this->createForm(DomaineactiviteType::class, $domaineactivite);

        $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted() && $form->isValid()){
            //on enregistre le domaine d'activité dans la bdd
            $em->persist($domaineactivite);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','Le domaine ('.$domaineactivite->getNomdomaine().') est ajouté !');

            //Retourne form de la liste des domaines d'activités
            return $this->redirect($this->generateUrl('showDomaineActivite'));

        }


        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('admin/domainesActivites/domainesActivitesAdd.html.twig', array('form'=>$formView));

    }

    /**
     * @Route("/admin/domaineactivite/show", name="showDomaineActivite")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showDomaineActivite(){
        $domainesActivites = $this->getDoctrine()->getRepository('AppBundle:Domaineactivite')->findAll();

        return $this->render('admin/domainesActivites/domainesActivitesShow.html.twig',['domainesActivites'=>$domainesActivites]);
    }

    /**
     * @param Request $request
     * @param Domaineactivite $domaineactivite
     * @param ObjectManager $em
     * @return Response
     * @Route("/admin/domaineactivite/{id}/edit", name="editDomaineActivite")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function edit(Request $request, Domaineactivite $domaineactivite, ObjectManager $em){
        $form = $this->createForm(DomaineactiviteType::class, $domaineactivite);

        $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted()){
            //on enregistre le domaine d'activité dans la bdd
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','Le domaine ('.$domaineactivite->getNomdomaine().') est modifié !');

            //Retourne form de la liste des domaines d'activités
            return $this->redirect($this->generateUrl('showDomaineActivite'));

        }


        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('admin/domainesActivites/domainesActivitesAdd.html.twig', array('form'=>$formView));
    }

    /**
     * @param Domaineactivite $domaineactivite
     * @param ObjectManager $em
     * @return Response
     * @Route("/admin/domaineactivite/{id}/delete", name="deleteDomaineActivite")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function delete(Domaineactivite $domaineactivite, ObjectManager $em){
        $em->remove($domaineactivite);
        $em->flush();
        // On affiche message de validation dans le formulaire de redirection
        $this->get('session')->getFlashBag()->add('notice','Le domaine ('.$domaineactivite->getNomdomaine().') est supprimé !');

        //Retourne form de la liste des domaines d'activités
        return $this->redirect($this->generateUrl('showDomaineActivite'));
    }

}
