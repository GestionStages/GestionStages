<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CommentProf;
use AppBundle\Entity\Professeur;
use AppBundle\Entity\Propositions;
use AppBundle\Form\CommentProfType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentProfController extends Controller
{
    /**
     * @Route("/prof/propositions", name="indexProfPropositions")
     * @IsGranted("ROLE_PROF")
     */
    public function indexPropositions() {
        /** @var Professeur $user */
        $user = $this->getUser();

        return $this->render('admin/profComments/propositionlist.html.twig', [
            'propositions' => $user->getPropositions()
        ]);
    }

    /**
     * @Route("/propositions/{id}/commentaires", name="commentairesProposition")
     * @IsGranted("ROLE_PROF")
     * @param Propositions $proposition
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function commentairesProposition(Propositions $proposition) {
        /** @var Professeur $user */
        $user = $this->getUser();

        if ($user->getId() != $proposition->getCodeProfesseur()->getId()) {
            $this->get('session')->getFlashBag()->add('error',"Cette proposition ne vous est pas affectée !");
            return $this->redirect($this->generateUrl('indexProfPropositions'));
        }

        return $this->render('admin/profComments/commentaireslist.html.twig', [
            'proposition' => $proposition,
            'commentaires' => $proposition->getCommentaires()
        ]);
    }

    /**
     * @Route("/proposition/{id}/addcomment", name="addProfComment")
     * @IsGranted("ROLE_PROF")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addCommentaire(Request $request, Propositions $proposition) {
        $user = $this->getUser();

        if ($user->getId() != $proposition->getCodeProfesseur()->getId()) {
            $this->get('session')->getFlashBag()->add('error',"Cette proposition ne vous est pas affectée !");
            return $this->redirect($this->generateUrl('indexProfPropositions'));
        }

        $commentaire = new CommentProf();

        $form = $this->createForm(CommentProfType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setDate(new \DateTime('NOW'));
            $commentaire->setProf($user);
            $commentaire->setProposition($proposition);

            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice','Le commentaire à été ajouté !');
            return $this->redirectToRoute('commentairesProposition', ['id' => $proposition->getCodeproposition()]);
        }

        $formview = $form->createView();

        return $this->render('admin/profComments/commentaireAdd.html.twig', [
            'form' => $formview
        ]);
    }
}
