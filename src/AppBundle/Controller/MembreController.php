<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etudiant;
use AppBundle\Entity\Professeur;
use AppBundle\Entity\Propositions;
use AppBundle\Form\EtudiantType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class MembreController extends Controller
{
    /**
     * @Route("/admin/membres/etu", name="listEtudiants")
     *
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
     *
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
     * @Route("/admin/membres/prof", name="listProfs")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listProfs() {
        $teachers = $this->getDoctrine()->getRepository(Professeur::class)->findAll();

        return $this->render('admin/membres/teachers.html.twig', [
            'professeurs' => $teachers
        ]);
    }
}
