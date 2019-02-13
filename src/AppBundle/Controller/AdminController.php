<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Properties;
use AppBundle\Entity\Propositions;
use AppBundle\Entity\Etat;
use AppBundle\Form\InfosGeneralesType;
use AppBundle\Form\PropositionsType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="showAdminHome")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function showHome()
    {
        $repository = $this->getDoctrine()->getRepository(Propositions::class);
        $attenteValid = $repository->nbEnAttenteValid();
        $valid = $repository->nbValid();
        $archive =$repository->nbArchive();
        $affecte = $repository->nbAffecte();
        $refuse = $repository->nbRefuse();
        $query = $repository->createQueryBuilder('p')
            ->where('p.codeetat = 1')
            ->orderBy('p.dateajout', 'DESC')
            ->getQuery();
        $propositions = $query->getResult();

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Entreprises');
        $nbEntrepriseEnAttente = $repository->nbEnAttente();
        $nbEntrepriseValid = $repository->nbValid();
        $entreprises = $repository->findEnattente();

        return $this->render('admin/home.html.twig', ['attenteValid'=>$attenteValid, 'valid'=>$valid, 'archive'=>$archive, 'affecte'=>$affecte, 'refuse'=>$refuse, 'propositions'=>$propositions,'entrepriseValid'=>$nbEntrepriseValid,'entrepriseAttente'=>$nbEntrepriseEnAttente,'entreprises'=>$entreprises]);
    }

    /**
     * @Route("/admin/offres", name="showAdminListAll")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showListAll()
    {
        $repository = $this->getDoctrine()->getRepository(Propositions::class);
        $propositions = $repository->findAllOrderDate();

        return $this->render('admin/propositions/list.html.twig',['propositions' => $propositions]);
    }

    /**
     * @Route("/admin/offresAttente", name="showAdminListAttente")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showListAttente()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Propositions');

        $propositions = $repository->findEnattente();

        return $this->render('admin/propositions/list.html.twig',['propositions' => $propositions]);
    }

    /**
     * @Route("/admin/offresValid", name="showAdminListValid")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showListValid()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Propositions');

        $propositions = $repository->findValid();

        return $this->render('admin/propositions/list.html.twig',['propositions' => $propositions]);
    }

    /**
     * @Route("/admin/offresArchive", name="showAdminListArchive")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showListArchive()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Propositions');

        $propositions = $repository->findArchive();

        return $this->render('admin/propositions/list.html.twig',['propositions' => $propositions]);
    }

    /**
     * @Route("/admin/offresRefuse", name="showAdminListRefuse")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showListRefuse()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Propositions');

        $propositions = $repository->findRefuse();

        return $this->render('admin/propositions/list.html.twig',['propositions' => $propositions]);
    }

    /**
     * @Route("admin/propositions/{id}", name="AdminPropositionbyid", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showPropositionById($id)
    {
        $proposition = $this->getDoctrine()
            ->getRepository('AppBundle:Propositions')
            ->find($id);

        return $this->render('admin/propositions/propositionShow.html.twig',['proposition' => $proposition]);
    }

    /**
     * @Route("/admin/stat", name="statAdmin")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function statAdmin()
    {
        //TODO: Function de test
        $repository = $this->getDoctrine()->getRepository(Propositions::class);
        $stat = $repository->nbEnAttenteValid();

        return new Response($stat);
    }

    /**
     * @param Request $request
     * @param Propositions $proposition
     * @Route("/admin/propositions/{id}/edit", name="editPropositionAdmin", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request, Propositions $proposition, ObjectManager $em)
    {
        $form = $this->createForm(PropositionsType::class, $proposition, [
            'doctrine' => $this->getDoctrine(),
            'roles' => $this->getUser()->getRoles()
        ]);

	    $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted() && $form->isValid()){
            //on enregistre la proposition dans la bdd
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','La proposition à été modifiée !');

            //Retourne form de la liste des domaines d'activités
            return $this->redirect($this->generateUrl('showAdminListAll'));
        }

        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('admin/propositions/propositionAdd.html.twig', array('form'=>$formView));
    }

    /**
     * @Route("/admin/offres/{id}/valid", name="validProposition", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Propositions $proposition
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function approve(Propositions $proposition, ObjectManager $em)
    {
        $etat = $this->getDoctrine()
            ->getRepository(Etat::class)
            ->find(2);

        if($proposition->getCodeentreprise()->getCodeetat()->getCodeetat() == 1){
           $entreprise = $proposition->getCodeentreprise();
           $entreprise->setCodeetat($etat);
        }
        $proposition->setCodeetat($etat);

        $em->flush();

        return $this->redirectToRoute('showAdminListAll');
    }

    /**
     * @Route("/admin/offres/{id}/reject", name="rejectProposition", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Propositions $proposition
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reject(Propositions $proposition, ObjectManager $em)
    {
        $etat = $this->getDoctrine()
            ->getRepository(Etat::class)
            ->find(5);

        $proposition->setCodeetat($etat);

        $em->flush();

        return $this->redirectToRoute('showAdminListAll');
    }

    /**
     * @Route("/admin/offres/{id}/archive", name="archiveProposition", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param $id
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function archive(Propositions $proposition, ObjectManager $em)
    {
        $etat = $this->getDoctrine()
            ->getRepository(Etat::class)
            ->find(4);

        $proposition->setCodeetat($etat);

        $em->flush();

        return $this->redirectToRoute('showAdminListAll');
    }

    /**
     * @Route("/admin/accueil/edit", name="editinfos")
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function editInfosAction(Request $request, ObjectManager $em) {
        $properties = $this->getDoctrine()->getRepository(Properties::class)->find(1);
        $form = $this->createForm(InfosGeneralesType::class, $properties);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice','Modification de l\'accueil enregistrée !');
            return $this->redirectToRoute('homepage');

        }

        $formview = $form->createView();

        return $this->render('admin/infosGenerales/infoGeneralesEdit.html.twig', [
            'form' => $formview
        ]);
    }
}
