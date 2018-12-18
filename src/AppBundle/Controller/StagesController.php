<?php

namespace AppBundle\Controller;

use Carbon\Carbon;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class StagesController extends Controller
{
    /**
     * @Route("/stages/{id}/convention", name="generateconvention", requirements={"id"="\d+"})
     */
    public function conventionaction() {
        $annee = Carbon::now()->subMonths(9)->year;

        //TODO: Remplacer avec une recherche BDD
        $chef_dep = [
            'nomProf' => "Garcia",
            'prenomProf' => "Francis"
        ];

        //TODO: Remplacer avec une recherche BDD
        $resp_stages = [
            'nomProf' => "Palleja",
            'prenomProf' => "Nathalie"
        ];

        //TODO: Remplacer avec une recherche BDD
        $entrep = [
            'nomEntreprise' => "ENTREPRISE MATHIEU",
            'adresseEntreprise' => '1243 Avenue du Pic Saint Loup',
            'villeEntreprise' => 'Mende',
            'codePostalEntreprise' => '48000',
            'telEntreprise' => '0123456789'
        ];

        //TODO: Remplacer avec une recherche BDD
        $etudiant = [
            'nomEtudiant' => "Servière",
            'prenomEtudiant' => "Mathieu",
            'mailEtudiant' => "serviere.98@hotmail.fr",
            'telEtudiant' => "07xxxxxxxx",
            'codeClasseEtudiant' => [
                'nomClasse' => "Une classe",
                'dateDebStage' => "1989-11-15",
                'dateFinStage' => "1998-11-09"
            ]
        ];
        $etudiant['codeClasseEtudiant']['diffDates'] = Carbon::parse($etudiant['codeClasseEtudiant']['dateDebStage'])
                                                        ->diffInWeeks(Carbon::parse($etudiant['codeClasseEtudiant']['dateFinStage']));
        $etudiant['codeClasseEtudiant']['dateDebStageStr'] = Carbon::parse($etudiant['codeClasseEtudiant']['dateDebStage'])->toDateString();
        $etudiant['codeClasseEtudiant']['dateFinStageStr'] = Carbon::parse($etudiant['codeClasseEtudiant']['dateFinStage'])->toDateString();

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
