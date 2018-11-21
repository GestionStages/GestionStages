<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Domaineactivite;
use AppBundle\Form\DomaineactiviteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DomaineactiviteController extends Controller

{
    /**
     *
     * @Route("/admin/domaineactivite/add", name="addDomaineActivite")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */

    public function addAction(Request $request)
    {
        //On crée un nouveau domaine d'activité
        $domaineactivite = new Domaineactivite();

        //On récupère le form
        $form = $this->createForm(DomaineactiviteType::class, $domaineactivite);

        $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted() && $form->isValid()){

            //on enregistre le domaine d'activité dans la bdd
            $em = $this-> getDoctrine()->getManager();
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
     *
     * @Route("/admin/domaineactivite/show", name="showDomaineActivite")
     *
     */
    public function showDomaineActivite(){
        $domainesActivites = $this->getDoctrine()->getRepository('AppBundle:Domaineactivite')->findAll();

        return $this->render('admin/domainesActivites/domainesActivitesShow.html.twig',['domainesActivites'=>$domainesActivites]);
    }

    /**
     * @param Domaineactivite $domaineactivite
     * @param Request $request
     * @return Response
     * @Route("/admin/domaineactivite/edit/{id}", name="editDomaineActivite")
     *
     */
    public function edit(Request $request, Domaineactivite $domaineactivite){
        $form = $this->createForm(DomaineactiviteType::class, $domaineactivite);

        $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted()){

            //on enregistre le domaine d'activité dans la bdd
            $em = $this-> getDoctrine()->getManager();
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
     * @return Response
     * @Route("/admin/domaineactivite/delete/{id}", name="deleteDomaineActivite")
     *
     *
     */

    public function delete(Domaineactivite $domaineactivite){
        $em = $this-> getDoctrine()->getManager();
        $em->remove($domaineactivite);
        $em->flush();
        // On affiche message de validation dans le formulaire de redirection
        $this->get('session')->getFlashBag()->add('notice','Le domaine ('.$domaineactivite->getNomdomaine().') est supprimé !');

        //Retourne form de la liste des domaines d'activités
        return $this->redirect($this->generateUrl('showDomaineActivite'));
    }

}
