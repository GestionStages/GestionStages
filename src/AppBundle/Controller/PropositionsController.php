<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classes;
use AppBundle\Entity\Contacts;
use AppBundle\Entity\Domaineactivite;
use AppBundle\Entity\Entreprises;
use AppBundle\Entity\Etat;
use AppBundle\Entity\Etudiant;
use AppBundle\Entity\Professeur;
use AppBundle\Entity\Propositions;
use AppBundle\Entity\Technologies;
use AppBundle\Form\PropositionsType;
use AppBundle\Repository\ContactsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Carbon\Carbon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PropositionsController extends Controller
{
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }


    /**
     * @Route("/propositions/add", name="addProposition")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addAction(Request $request, ObjectManager $em)
    {
        //On crée une nouvelle proposition
        $proposition = new Propositions();

        //On récupère le form
        $form = $this->createForm(PropositionsType::class, $proposition, [
            'doctrine' => $this->getDoctrine(),
            'roles' => $this->getUser()->getRoles()
        ]);
        $form->handleRequest($request);

        //si le formulaire a été soumis et qu'il est valide
        if($form->isSubmitted() && $form->isValid()){
            /** @var Etat $etat */
            $etat = $this->getDoctrine()->getRepository(Etat::class)
                         ->find(1);

            // on affecte l'etat en attente par default
            $proposition->setCodeetat($etat);
            $proposition->setDateajout(new \DateTime('NOW'));

            /** @var UploadedFile $file */
            if(!is_null($file = $proposition->getFile())) {
                $filename = $this->generateUniqueFileName().".".$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('fileDirectory'),
                        $filename
                    );

                    $proposition->setFile($filename);
                } catch (FileException $e) {}
            }

            $em->persist($proposition);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','La proposition a été ajoutée !');

            //Retourne form de la liste des domaines d'activités
            return $this->redirect($this->generateUrl('afficherProposition'));
        }

        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('propositions/propositionAdd.html.twig', array('form'=>$formView));
    }

    /**
     * @Route("/propositions/{id}", name="afficherPropositionbyid", requirements={"id"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function showPropositionById($id)
    {
        $proposition = $this->getDoctrine()
            ->getRepository('AppBundle:Propositions')
            ->find($id);

        return $this->render('propositions/propositionShow.html.twig',['proposition' => $proposition]);
    }

    /**
     * @Route("/propositions/{id}/affecterEtudiant", name="affecterEtudiant", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function affecterEtudiant(Request $request, ObjectManager $em)
    {
        $proposition = $this->getDoctrine()->getRepository(Propositions::class)->find($request->get('id'));
        if(!$request->get('etudiant')){
            $etudiants = $this->getDoctrine()->getRepository(Etudiant::class)->findNonAffecter();

            return $this->render('/admin/propositions/affecterEtudiant.html.twig', ['etudiants' => $etudiants, 'proposition' => $proposition]);
        }
        else{
            $etudiant =  $this->getDoctrine()->getRepository(Etudiant::class)->find($request->get('etudiant'));
            $proposition->setCodeEtudiant($etudiant);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','L\'étudiant à été affecté !');
            return $this->redirect($this->generateUrl('showAdminListAll'));

        }
    }

    /**
     * @Route("/propositions/{id}/desaffecterEtudiant", name="desaffecterEtudiant", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function desaffecterEtudiant(Request $request, ObjectManager $em){
        $proposition = $this->getDoctrine()->getRepository(Propositions::class)->find($request->get('id'));
        $proposition->setCodeEtudiant(null);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice','L\'étudiant n\'est plus affecté !');
        return $this->redirect($this->generateUrl('showAdminListAll'));

    }

    /**
     * @Route("/propositions/{id}/affecterProfesseur", name="affecterProfesseur", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function affecterProfesseur(Request $request, ObjectManager $em)
    {
        $proposition = $this->getDoctrine()->getRepository(Propositions::class)->find($request->get('id'));
        if(!$request->get('professeur')){
            $professeurs = $this->getDoctrine()->getRepository(Professeur::class)->findOrdered();

            return $this->render('/admin/propositions/affecterProfesseur.html.twig', ['professeurs' => $professeurs, 'proposition' => $proposition]);
        }
        else{
            $professeur =  $this->getDoctrine()->getRepository(Professeur::class)->find($request->get('professeur'));
            $proposition->setCodeProfesseur($professeur);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','Le professeur à été affecté !');
            return $this->redirect($this->generateUrl('showAdminListAll'));

        }
    }

    /**
     * @Route("/propositions/{id}/desaffecterProfesseur", name="desaffecterProfesseur", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function desaffecterProfesseur(Request $request, ObjectManager $em){
        $proposition = $this->getDoctrine()->getRepository(Propositions::class)->find($request->get('id'));
        $proposition->setCodeProfesseur(null);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice','Le tuteur n\'est plus affecté !');
        return $this->redirect($this->generateUrl('showAdminListAll'));
    }

    /**
     * @Route("/propositions/{id}/affecterContact", name="affecterContact", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function affecterContact(Request $request, ObjectManager $em, Propositions $proposition)
    {
        if(!$request->get('contact')){
            /** @var ContactsRepository $repository */
            $repository = $this->getDoctrine()
                ->getRepository(Contacts::class);

            $contacts = $repository->getEntrepriseContactsOrdered($proposition->getCodeentreprise());

            return $this->render('admin/propositions/affecterContact.html.twig', ['contacts' => $contacts, 'proposition' => $proposition]);
        }
        else{
            $contact =  $this->getDoctrine()->getRepository(Contacts::class)->find($request->get('contact'));
            $proposition->setCodeContact($contact);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','Le tuteur à été affecté !');
            return $this->redirect($this->generateUrl('showAdminListAll'));
        }
    }

    /**
     * @Route("/propositions/{id}/desaffecterContact", name="desaffecterContact", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function desaffecterContact(Request $request, ObjectManager $em){
        $proposition = $this->getDoctrine()->getRepository(Propositions::class)->find($request->get('id'));
        $proposition->setCodeContact(null);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice','Le tuteur n\'est plus affecté !');
        return $this->redirect($this->generateUrl('showAdminListAll'));
    }

    /**
     * @param Request $request
     * @param Propositions $proposition
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/propositions/{id}/edit", name="editProposition", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function edit(Request $request, Propositions $proposition, ObjectManager $em)
    {
	    $form = $this->createForm(PropositionsType::class, $proposition, [
	        'doctrine' => $this->getDoctrine(),
            'roles' => $request->getUser()->getRoles()
        ]);

	    $form->handleRequest($request);

        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid()){
            /** @var UploadedFile $file */
            if(!is_null($file = $proposition->getFile())) {
                $filename = $this->generateUniqueFileName().".".$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('fileDirectory'),
                        $filename
                    );

                    $proposition->setFile($filename);
                } catch (FileException $e) {
                    $this->get('session')->getFlashBag()->add('error','Une erreur est survenue lors de la sauvegarde du fichier !');
                    return $this->render('propositions:propositionAdd.html.twig', array('form'=>$form->createView()));
                }
            }

            /** @var Entreprises $entreprise */
            $entreprise = $form->getData()->getCodeEntreprise();
            if($entreprise->getBlacklister()) {
                $this->get('session')->getFlashBag()->add('error',"L'entreprise sélectionnée est invalide !");
                return $this->render('propositions:propositionAdd.html.twig', array('form'=>$form->createView()));
            }

            //on enregistre la proposition dans la bdd
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','La proposition à été modifiée !');

            //Retourne form de la liste des domaines d'activités
            return $this->redirect($this->generateUrl('afficherProposition'));
        }

        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('propositions/propositionAdd.html.twig', array('form'=>$formView));
    }

    /**
     * @Route("/propositions", name="afficherProposition")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function showProposition(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Propositions::class);

        /** @var Domaineactivite[] $domainesAct */
        $domainesAct = $this->getDoctrine()->getRepository(Domaineactivite::class)->findAll();

        /** @var Classes[] $classes */
        $classes = $this->getDoctrine()->getRepository(Classes::class)->findAll();

        /** @var Technologies[] $technos */
        $technos = $this->getDoctrine()->getRepository(Technologies::class)->findAll();

        $checkedClasses = $request->get('classes');
        $checkedDomaines = $request->get('domaines');
        $checkedTechnos = $request->get('technos');

        $propositions = $repository->filter($checkedClasses, $checkedDomaines, $checkedTechnos);

        return $this->render('propositions/propositionsShow.html.twig',[
            'propositions' => $propositions,
            'domaineActivites'=> $domainesAct,
            'checkedDomaines' => $checkedDomaines,
            'technologies' => $technos,
            'checkedTechnos' => $checkedTechnos,
            'classes' => $classes,
            'checkedClasses' => $checkedClasses
        ]);
    }

    /**
     * @Route("/propositions/{id}/deleteFile", name="deletepropositionfile", requirements={"id"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @param Propositions $proposition
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteFile(Propositions $proposition, ObjectManager $em) {
        //Suppression du fichier
        $file = $proposition->getFile();
        unlink($this->getParameter('fileDirectory')."/".$file);

        //Suppression de la référence en DB
        $proposition->setFile(null);
        $em->flush();

        // On affiche message de validation dans le formulaire de redirection
        $this->get('session')->getFlashBag()->add('notice','La proposition à été modifiée !');

        //Retourne form de la liste des domaines d'activités
        return $this->redirect($this->generateUrl('afficherPropositionbyid',['id' => $proposition->getCodeproposition()]));
    }

    /**
     * @Route("/propositions/{id}/convention", name="generateconvention", requirements={"id"="\d+"})
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Propositions $proposition
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function conventionaction(Propositions $proposition) {
        if (is_null($proposition->getCodeEtudiant())) {
            $this->get('session')->getFlashBag()->add('error', "Cette proposition n'as pas d'étudiant affecté");
            return $this->redirectToRoute('homepage');
        }

        $profRepo = $this->getDoctrine()->getRepository(Professeur::class);

        $annee = Carbon::now()->subMonths(9)->year;

        /** @var Professeur $chef_dep */
        $chef_dep = $profRepo->findOneByRoleProf(3);

        /** @var Professeur $resp_stages */
        $resp_stages = $profRepo->findOneByRoleProf(2);

        $entrep = $proposition->getCodeentreprise();

        $etudiant = $proposition->getCodeEtudiant();
        $etudiant->getCodeclasse()->diffDates = Carbon::instance($etudiant->getCodeclasse()->getDateDebStage())
                 ->diffInWeeks(Carbon::instance($etudiant->getCodeclasse()->getDateFinStage()));

        switch ($etudiant->getSexeEtudiant()) {
            case 'h':
                $etudiant->setSexeEtudiant("Homme");
                break;

            case 'f':
                $etudiant->setSexeEtudiant("Femme");
                break;

            default:
                $etudiant->setSexeEtudiant("Autre");
                break;
        }

        $html2pdf = $this->get('html2pdf_factory')->create();
        $html2pdf->writeHTML($this->renderView('stages/convention.html.twig', [
            'annee_str' => $annee."/".($annee+1),
            'chef_dep' => $chef_dep,
            'resp_stages' => $resp_stages,
            'entreprise' => $entrep,
            'etudiant' => $etudiant
        ]));

        try {
            return $html2pdf->output('convention.pdf');
        } catch (Html2PdfException $e) {
            $this->get('session')->getFlashBag()->add('error', "Une erreur est survenue lors de la génération du PDF");
            return $this->redirectToRoute('homepage');
        }
    }
}
