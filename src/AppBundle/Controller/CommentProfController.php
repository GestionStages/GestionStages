<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Professeur;
use AppBundle\Entity\Propositions;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

        if ($user->getId() != $proposition->getCodeProfesseur()) {
            $this->get('session')->getFlashBag()->add('error',"Cette proposition ne vous est pas affectée !");
            return $this->redirect($this->generateUrl('indexProfPropositions'));
        }

        return $this->render('admin/profComments/commentaireslist.html.twig', [
            'commentaires' => $proposition->getCommentaires()
        ]);
    }
}
