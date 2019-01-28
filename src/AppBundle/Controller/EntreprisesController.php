<?php
/**
 * Created by PhpStorm.
 * User: axelc
 * Date: 23/10/2018
 * Time: 23:32
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Entreprises;
use AppBundle\Form\EntreprisesType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EntreprisesController extends Controller
{

    /**
     * @Route("/admin/entreprises/add", name="addEntreprise")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, ObjectManager $em){
        // creer un new Entreprise
        $entreprise = new Entreprises();

        // recuperer le form
        $form = $this->createForm(EntreprisesType::class,$entreprise);

        $form->handleRequest($request);

        //si le formulaire est validé
        if($form->isSubmitted() && $form->isValid()){
            // on enregistre l'entreprise en BDD
            $em->persist($entreprise);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','Entreprise ('.$entreprise->getNomentreprise().') ajoutée !');

            // Retourne form de la liste des entreprises
            return $this->redirect($this->generateUrl('showEntreprises'));
        }

        //generer HTML du form
        $formView = $form->createView();

        // on retourne la vue
        return $this->render('admin/entreprises/entrepriseAdd.html.twig',array('form'=>$formView));
    }

    /**
     * @param Request $request
     * @param Entreprises $entreprise
     * @param ObjectManager $em
     * @return Response
     * @Route("/admin/entreprises/{id}/edit", name="editEntreprise")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function edit(Request $request, Entreprises $entreprise, ObjectManager $em){
        $form = $this->createForm(EntreprisesType::class, $entreprise);

        $form->handleRequest($request);

        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid()){
            //on enregistre l'entreprise dans la bdd
            $em->flush();

            //Envoi un message de validation
            $this->get('session')->getFlashBag()->add('notice','Entreprise ('.$entreprise->getNomentreprise().') modifiée !');

            // Retourne form de la liste des entreprises
            return $this->redirect($this->generateUrl('showEntreprises'));
        }

        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('admin/entreprises/entrepriseAdd.html.twig', array('form'=>$formView));
    }

    /**
     * @param Entreprises $entreprise
     * @param ObjectManager $em
     * @return Response
     * @Route("/admin/entreprises/{id}/blacklist", name="blackListEntreprise")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function blackListEntreprise(Entreprises $entreprise, ObjectManager $em){
        //modification de l'attribut blacklist de l'objet
        $entreprise->setBlacklister(1);

        //enregistrement en BDD de la modification
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice','L\'Entreprise ('.$entreprise->getNomentreprise().') est dans la BlackList !');
        return $this->redirect($this->generateUrl('showEntreprises'));
    }

    /**
     * @param Entreprises $entreprise
     * @param ObjectManager $em
     * @return Response
     * @Route("/admin/entreprises/{id}/noblacklist", name="noBlackListEntreprise")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function noblackListEntreprise(Entreprises $entreprise, ObjectManager $em){
        //modification de l'attribut blacklist de l'objet
        $entreprise->setBlacklister(0);

        //enregistrement en BDD de la modification
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice','L\'Entreprise ('.$entreprise->getNomentreprise().') est revenue dans la liste !');
        return $this->redirect($this->generateUrl('showEntreprisesBlackList'));
    }

    /**
     * @Route("/admin/entreprises", name="showEntreprises")
     * @return Response
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function showEntreprises()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);

        $entreprises = $repository->findBlacklisted(false);

        return $this->render('admin/entreprises/entreprisesShow.html.twig',['entreprises' => $entreprises]);
    }

    /**
     * @Route("/admin/entreprisesBlackList", name="showEntreprisesBlackList")
     * @return Response
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function showEntreprisesBlackList()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);

        $entreprises = $repository->findBlacklisted(true);

        return $this->render('admin/entreprises/entreprisesShowBlackList.html.twig',['entreprises' => $entreprises]);
    }

    /**
     * @Route("/admin/entreprises/{id}/delete", name="deleteEntreprise")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @param Entreprises $entreprise
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteEntreprise(Entreprises $entreprise, ObjectManager $manager) {
        $manager->remove($entreprise);
        $manager->flush();

        $this->get('session')->getFlashBag()->add('notice',"L'entreprise (".$entreprise->getNomEntreprise().") est supprimé !");
        return $this->redirect($this->generateUrl('showEntreprises'));
    }

	/**
	 * @Route("/entreprises/search")
	 * @param Request $request
	 * @return Response
	 */
    public function searchEntreprise(Request $request)
    {
    	$q = $request->query->get('term');
    	$results = $this->getDoctrine()->getRepository(Entreprises::class)
                        ->findLikeName($q);

    	return $this->render('entreprises/list.json.twig', ['results' => $results]);
    }
}