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
     * @Route("/domaineactivite/add", name="addDomaineActivite")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */

    public function addAction(Request $request)
    {
        //On crée un nouveau domaine d'activité
        $domaineAct = new Domaineactivite();

        //On récupère le form
        $form = $this->createForm(DomaineactiviteType::class, $domaineAct);

        $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted()){

            //on enregistre le domaine d'activité dans la bdd
            $em = $this-> getDoctrine()->getManager();
            $em->persist($domaineAct);
            $em->flush();

            //A la place d'une reponse, il faut renvoyer une vue ! (style avec la liste des domaines...)
            return new Response('Domaine Ajouté !');

        }


        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('domaineActAdd.html.twig', array('form'=>$formView));

    }

}
