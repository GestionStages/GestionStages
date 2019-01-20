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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request){
        // creer un new Entreprise
        $entreprise = new Entreprises();

        // recuperer le form
        $form = $this->createForm(EntreprisesType::class,$entreprise);

       $form->handleRequest($request);

       //si le formulaire est validé
        if($form->isSubmitted() && $form->isValid()){
            // on enregistre l'entreprise en BDD
            $em = $this->getDoctrine()->getManager();

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
     * @return Response
     * @Route("/admin/entreprises/{id}/edit", name="editEntreprise")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function edit(Request $request, Entreprises $entreprise){
        $form = $this->createForm(EntreprisesType::class, $entreprise);

        $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted() && $form->isValid()){
            //on enregistre l'entreprise dans la bdd
            $em = $this-> getDoctrine()->getManager();
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
     * @return Response
     * @Route("/admin/entreprises/{id}/blacklist", name="blackListEntreprise")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function blackListEntreprise(Entreprises $entreprise){
        //modification de l'attribut blacklist de l'objet
        $entreprise->setBlacklister(1);
        //enregistrement en BDD de la modification
        $em = $this-> getDoctrine()->getManager();
        $em->flush();
        $this->get('session')->getFlashBag()->add('notice','L\'Entreprise ('.$entreprise->getNomentreprise().') est dans la BlackList !');
        return $this->redirect($this->generateUrl('showEntreprises'));
    }

    /**
     * @param Entreprises $entreprise
     * @return Response
     * @Route("/admin/entreprises/{id}/noblacklist", name="noBlackListEntreprise")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function noblackListEntreprise(Entreprises $entreprise){
        //modification de l'attribut blacklist de l'objet
        $entreprise->setBlacklister(0);
        //enregistrement en BDD de la modification
        $em = $this-> getDoctrine()->getManager();
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
        //TODO: A Déplacer dans repository EntrepriseRepository
        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);

        $query = $repository->createQueryBuilder('e')
            ->where('e.blacklister = 0')
            ->getQuery();

        $entreprises = $query->getResult();

        return $this->render('admin/entreprises/entreprisesShow.html.twig',['entreprises' => $entreprises]);
    }

    /**
     * @Route("/admin/entreprisesBlackList", name="showEntreprisesBlackList")
     * @return Response
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function showEntreprisesBlackList()
    {
        //TODO: A Déplacer dans repository EntrepriseRepository
        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);

        $query = $repository->createQueryBuilder('e')
            ->where('e.blacklister = 1')
            ->getQuery();

        $entreprises = $query->getResult();

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