<?php
/**
 * Created by PhpStorm.
 * User: axelc
 * Date: 23/10/2018
 * Time: 23:32
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Entreprises;
use AppBundle\Entity\Propositions;
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
     * @IsGranted("ROLE_RESPSTAGES")
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
            $etat = $em->getRepository('AppBundle:Etat')
                ->find("2");

            $entreprise->setCodeetat($etat);
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
     * @IsGranted("ROLE_RESPSTAGES")
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
     * @IsGranted("ROLE_RESPSTAGES")
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
     * @IsGranted("ROLE_RESPSTAGES")
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
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showEntreprises()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);

        $entreprises = $repository->findBlacklisted(false);

        return $this->render('admin/entreprises/entreprisesShow.html.twig',['entreprises' => $entreprises]);
    }

    /**
     * @Route("/admin/entreprisesEnAttente", name="showEntreprisesEnAttente")
     * @return Response
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showEntreprisesEnAttente()
    {
        $repository = $this->getDoctrine()->getRepository(Entreprises::class);

        $entreprises = $repository->findEnattente();

        return $this->render('admin/entreprises/entreprisesShow.html.twig',['entreprises' => $entreprises]);
    }

    /**
     * @Route("/admin/entreprisesValid", name="showEntreprisesValid")
     * @return Response
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function showEntreprisesValid()
    {
        $repository = $this->getDoctrine()->getRepository(Entreprises::class);

        $entreprises = $repository->findValid();

        return $this->render('admin/entreprises/entreprisesShow.html.twig',['entreprises' => $entreprises]);
    }

    /**
     * @Route("/admin/entreprisesBlackList", name="showEntreprisesBlackList")
     * @return Response
     * @IsGranted("ROLE_RESPSTAGES")
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
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Entreprises $entreprise
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteEntreprise(Entreprises $entreprise, ObjectManager $manager) {

        $repository = $this->getDoctrine()
            ->getRepository(Propositions::class);

        $query = $repository->createQueryBuilder('p')
            ->where('p.codeentreprise = :entreprise')
            ->setParameter('entreprise', $entreprise->getCodeentreprise())
            ->getQuery();

        $propositions = $query->getResult();

        if(!$propositions){

            $manager->remove($entreprise);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('notice',"L'entreprise (".$entreprise->getNomEntreprise().") est supprimé !");
            return $this->redirect($this->generateUrl('showEntreprises'));

        }else{
            $this->get('session')->getFlashBag()->add('error',"L'entreprise (".$entreprise->getNomEntreprise().") ne peut être supprimée car elle possède au moins une proposition !");
            return $this->redirect($this->generateUrl('showEntreprises'));
        }

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

    /**
     * @Route("/entreprises/create", name="createEntreprise")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request){
        // creer un new Entreprise
        $entreprise = new Entreprises();

        // recuperer le form
        $form = $this->createForm(EntreprisesType::class,$entreprise);

        $form->handleRequest($request);

        //si le formulaire est validé
        if($form->isSubmitted() && $form->isValid()){
            // on enregistre l'entreprise en BDD
            $em = $this->getDoctrine()->getManager();

            $etat = $em->getRepository('AppBundle:Etat')
                ->find("1");

            $entreprise->setCodeetat($etat);
            $em->persist($entreprise);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','Entreprise ('.$entreprise->getNomentreprise().') inscrite, en attente d\'une validation !');

            // Retourne form de la liste des entreprises
            return $this->redirect($this->generateUrl('homepage'));
        }

        //generer HTML du form
        $formView = $form->createView();

        // on retourne la vue
        return $this->render('inscription/entreprise.html.twig',array('form'=>$formView));
    }

    /**
     * @Route("/admin/entreprises/{id}/valid", name="validEntreprise", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function validEntreprise($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entreprise = $em->getRepository('AppBundle:Entreprises')
            ->find($id);

        $etat = $em->getRepository('AppBundle:Etat')
            ->find("2");

        $entreprise->setCodeetat($etat);

        $em->flush();

        return $this->redirectToRoute('showEntreprises');
    }
}