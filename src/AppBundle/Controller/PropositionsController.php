<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classes;
use AppBundle\Entity\Domaineactivite;
use AppBundle\Entity\Etat;
use AppBundle\Entity\Propositions;
use AppBundle\Form\PropositionsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PropositionsController extends Controller
{
    /**
     * @Route("/add", name="addProposition")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function addAction(Request $request)
    {

        //On crée une nouvelle proposition
        $proposition = new Propositions();

        //On récupère le form
        $form = $this->createForm(PropositionsType::class, $proposition);
        $form->handleRequest($request);

        //si le formulaire a été soumis et qu'il est valide

        if($form->isSubmitted() && $form->isValid()){
            $repository = $this->getDoctrine()
                ->getRepository(Etat::class);

            //recuperation de l'entreprise par l'id passer en session
            $etat = $repository->createQueryBuilder('e')
                ->where('e.codeetat = 1')
                ->getQuery()
                // Cette ligne permet de récupérer directement l'objet et non un tableau avec l'objet à l'interieur
                ->getOneOrNullResult();

            //on enregistre la proposition dans la bdd
            $em = $this-> getDoctrine()->getManager();
            // on affecte l'etat en attente par default
            $proposition->setCodeetat($etat);
            $proposition->setDateajout(new \DateTime('NOW'));
            $em->persist($proposition);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','La proposition à été ajoutée !');

            //Retourne form de la liste des domaines d'activités
            return $this->redirect($this->generateUrl('afficherProposition'));
        }

        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('propositions/propositionAdd.html.twig', array('form'=>$formView));
    }

    /**
     * @Route("/show/{id}", name="afficherPropositionbyid", requirements={"id"="\d+"})
     */
    public function showPropositionById($id)
    {
        $proposition = $this->getDoctrine()
            ->getRepository('AppBundle:Propositions')
            ->find($id);

        return $this->render('propositions/propositionShow.html.twig',['proposition' => $proposition]);
    }

    /**
     * @param Request $request
     * @param Propositions $proposition
     * @Route("/edit/{id}", name="editProposition", requirements={"id"="\d+"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request, Propositions $proposition)
    {
        $form = $this->createForm(PropositionsType::class, $proposition);

        $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted() && $form->isValid()){
            //on enregistre la proposition dans la bdd
            $em = $this-> getDoctrine()->getManager();
            $em->persist($proposition);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','La proposition à été ajoutée !');

            //Retourne form de la liste des domaines d'activités
            return $this->redirect($this->generateUrl('afficherPropositionbyid',['id' => $proposition->getCodeproposition()]));
        }

        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('propositions/propositionAdd.html.twig', array('form'=>$formView));
    }

    /**
     * @Route("/show", name="afficherProposition")
     */
    public function showProposition()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Propositions::class);

        $query = $repository->createQueryBuilder('p')
            ->where('p.codeetat = 2')
            ->orderBy('p.dateajout', 'DESC')
            ->getQuery();
        $domaineAct = $this->getDoctrine()->getRepository(Domaineactivite::class)->findAll();

        $propositions = $query->getResult();

        return $this->render('propositions/propositionsShow.html.twig',['propositions' => $propositions, 'domaineActivites'=>$domaineAct]);
    }

}
