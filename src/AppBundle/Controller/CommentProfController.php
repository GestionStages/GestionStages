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
}
