<?php
/**
 * Created by PhpStorm.
 * User: axelc
 * Date: 08/11/2018
 * Time: 20:31
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Classes;
use AppBundle\Form\ClassesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassesController extends Controller
{
    /**
     *
     * @Route("/admin/classes/add", name="addClasse")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request){
        // creer un new Classe
        $classe = new Classes();

        // recuperer le form
        $form = $this->createForm(ClassesType::class,$classe);

        $form->handleRequest($request);

        //si le formulaire est validé
        if($form->isSubmitted() && $form->isValid()){
            // on verifie que la dateFin ne soit pas inferieur a la dateDeb
            if ($form->getData()->getDateFinStage() > $form->getData()->getDateDebStage()){

                // on enregistre la classe en BDD
                $em = $this->getDoctrine()->getManager();

                $em->persist($classe);
                $em->flush();



                // On affiche message de validation dans le formulaire de redirection
                $this->get('session')->getFlashBag()->add('notice','Classe ('.$classe->getNomclasse().') ajoutée !');
                return $this->redirect($this->generateUrl('showClasses'));
            }
            $this->get('session')->getFlashBag()->add('notice','La période du stage est incorrecte !');
            return $this->render('admin/classes/classeAdd.html.twig', array('form'=>$form->createView()));
        }

        //generer HTML du form
        $formView = $form->createView();

        // on retourne la vue
        return $this->render('admin/classes/classeAdd.html.twig',array('form'=>$formView));
    }

    /**
     * @param Request $request
     * @param Classes $classe
     * @return Response
     * @Route("/admin/classes/edit/{id}", name="editClasse")
     */
    public function edit(Request $request, Classes $classe){
        $form = $this->createForm(ClassesType::class, $classe);

        $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted() && $form->isValid()){

            //on enregistre la classe dans la bdd
            $em = $this-> getDoctrine()->getManager();
            $em->flush();

            //Envoi un message de validation
            $this->get('session')->getFlashBag()->add('notice','Classe ('.$classe->getNomclasse().') modifiée !');

            // Retourne form de la liste des classes
            return $this->redirect($this->generateUrl('showClasses'));

        }


        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('admin/classes/classeAdd.html.twig', array('form'=>$formView));
    }



    /**
    * @param Classes $classe
    * @return Response
    * @Route("/admin/classes/delete/{id}", name="deleteClasse")
    *
    */

    public function delete(Classes $classe){
        $em = $this-> getDoctrine()->getManager();
        $em->remove($classe);
        $em->flush();
        // On affiche message de validation dans le formulaire de redirection
        $this->get('session')->getFlashBag()->add('notice','Le classe ('.$classe->getNomclasse().') est supprimée !');

        //Retourne form de la liste des classes
        return $this->redirect($this->generateUrl('showClasses'));
    }

    /**
     *
     * @Route("/admin/classes/", name="showClasses")
     *
     * @return Response
     *
     */
    public function showClasses()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Classes::class);

        $query = $repository->createQueryBuilder('e')
            ->getQuery();

        $classes = $query->getResult();

        return $this->render('admin/classes/classesShow.html.twig',['classes' => $classes]);
    }

}