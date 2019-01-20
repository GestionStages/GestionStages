<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etudiant;
use AppBundle\Entity\Professeur;
use AppBundle\Entity\Propositions;
use AppBundle\Form\EtudiantType;
use AppBundle\Form\ProfesseurType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class MembreController extends Controller
{
    /**
     * @Route("/admin/membres/etu", name="listEtudiants")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listEtudiants() {
        /** @var Etudiant[] $students */
        $students = $this->getDoctrine()->getRepository(Etudiant::class)->findAll();

        $propManager = $this->getDoctrine()->getRepository(Propositions::class);

        foreach ($students as $student) {
            $student->stage = $stage = $propManager->findOneByCodeEtudiant($student->getId());
        }

        return $this->render('admin/membres/students.html.twig', [
            'etudiants' => $students
        ]);
    }

    /**
     * @Route("/admin/membres/etu/{id}/edit", name="editEtudiant", requirements={"id"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @param Etudiant $etudiant
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editEtudiant(Etudiant $etudiant, Request $request, ObjectManager $manager) {
        $oldPassword = $etudiant->getPassword();

        $form = $this->createForm(EtudiantType::class, $etudiant, ['validation_groups' => ['edit', 'Default']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (empty($etudiant->getPassword())) {
                $etudiant->setPassEtudiant($oldPassword);
            }

            $manager->persist($etudiant);
            $manager->flush();

            return $this->redirectToRoute('listEtudiants');
        }

        return $this->render('admin/membres/studentsEdit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/membres/etu/{id}/delete", name="deleteEtudiant", requirements={"id"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @param Etudiant $etudiant
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteEtu(Etudiant $etudiant, ObjectManager $manager) {
        $manager->remove($etudiant);
        $manager->flush();

        $this->get('session')->getFlashBag()->add('notice',"L'étudiant (".strtoupper($etudiant->getNomEtudiant())." ".ucfirst($etudiant->getPrenomEtudiant()).") est supprimé !");
        return $this->redirectToRoute('listEtudiants');
    }

    /**
     * @Route("/admin/membres/prof", name="listProfs")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listProfs() {
        /** @var Professeur[] $teachers */
        $teachers = $this->getDoctrine()->getRepository(Professeur::class)->findAll();

        return $this->render('admin/membres/teachers.html.twig', [
            'professeurs' => $teachers
        ]);
    }

    /**
     * @Route("/admin/membres/prof/{id}/edit", name="editProf", requirements={"id"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @param Professeur $professeur
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editProf(Professeur $professeur, Request $request, ObjectManager $manager) {
        $oldPassword = $professeur->getPassword();

        $form = $this->createForm(ProfesseurType::class, $professeur, ['validation_groups' => ['edit', 'Default']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (empty($professeur->getPassword())) {
                $professeur->setPassProf($oldPassword);
            }

            $manager->persist($professeur);
            $manager->flush();

            return $this->redirectToRoute('listProfs');
        }

        return $this->render('admin/membres/teachersEdit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/membres/prof/{id}/delete", name="deleteProf", requirements={"id"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @param Professeur $professeur
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteProf(Professeur $professeur, ObjectManager $manager) {
        $manager->remove($professeur);
        $manager->flush();

        $this->get('session')->getFlashBag()->add('notice',"Le professeur (".strtoupper($professeur->getNomProf())." ".ucfirst($professeur->getPrenomProf()).") est supprimé !");
        return $this->redirectToRoute('listProfs');
    }
}
