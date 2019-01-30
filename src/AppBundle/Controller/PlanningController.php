<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Properties;
use AppBundle\Form\HorairesSoutenanceType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends Controller
{
    /**
     * @Route("/admin/planning/edithoraires", name="editHoraires")
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editHoraires(Request $request, ObjectManager $em)
    {
        $properties = $this->getDoctrine()->getRepository(Properties::class)->find(1);
        $form = $this->createForm(HorairesSoutenanceType::class, $properties);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Modification effectuée !');
        }

        $formview = $form->createView();
        return $this->render('admin/planning/edit_horaires.html.twig', [
            'form' => $formview
        ]);
    }
}
