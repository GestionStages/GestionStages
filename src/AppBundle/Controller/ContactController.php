<?php
/**
 * Created by PhpStorm.
 * User: axelc
 * Date: 26/10/2018
 * Time: 23:00
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Contacts;
use AppBundle\Entity\Entreprises;
use AppBundle\Form\ContactInscriptionType;
use AppBundle\Form\ContactsType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ContactController extends Controller
{
    /**
     *
     * @Route("/admin/contact/add", name="addContact")
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Request $request
     * @param SessionInterface $session
     * @param \Swift_Mailer $mailer
     * @param ObjectManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, SessionInterface $session, \Swift_Mailer $mailer, ObjectManager $em)
    {

        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);

        //recuperation de l'entreprise par l'id passer en session
        $entreprise = $repository->find($session->get('entreprise'));

        //On crée un nouveau contact
        $contact = new Contacts();

        // On affecte le contact a l'entreprise
        $contact->setCodeentreprise($entreprise);

        //On récupère le form
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid()){

            //on enregistre le contact dans la bdd
            $contact->setCodeInscription(sha1($contact->getMailcontact()));
            $em->persist($contact);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Demande d\'inscription sur la plateforme de l\'IUT de Montpellier')
                ->setFrom('stages-iutms@umontpellier.fr')
                ->setTo($contact->getMailcontact())
                ->setBody(
                    $this->renderView('admin/contacts/registrationMail.html.twig', ['contact' => $contact]),
                    'text/html'
                );

            $mailer->send($message);

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','Le contact ('.$contact->getNomcontact(). " " . $contact->getPrenomcontact() . ') est ajouté !');

            //Retourne form de la liste des contacts de l'entreprise
            return $this->redirectToRoute('showContacts', ['id' => $entreprise->getCodeentreprise()]);
        }

        //On génére le fichier final
        $formView = $form->createView();

        //on rend la vue
        return $this->render('admin/contacts/contactAdd.html.twig', array('form'=>$formView,'entreprise'=> $entreprise));
    }

    /**
     * @param Request $request
     * @param Contacts $contact
     * @param SessionInterface $session
     * @param ObjectManager $em
     * @return Response
     * @Route("/admin/contacts/{id}/edit", name="editContact")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function edit(Request $request, Contacts $contact, SessionInterface $session, ObjectManager $em){
        $form = $this->createForm(ContactsType::class, $contact);

        $form->handleRequest($request);

        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);

        $entreprise = $repository->find($session->get('entreprise'));

        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid()){
            //on enregistre l'entreprise dans la bdd
            $em->flush();

                //Envoi un message de validation
                $this->get('session')->getFlashBag()->add('notice','Contact ('.$contact->getNomcontact() . " " . $contact->getPrenomcontact() .') modifié !');

            // Retourne form de la liste des contacts de l'entreprise
            return $this->redirectToRoute('showContacts',['id' => $entreprise->getCodeentreprise()]);
        }

            //On génére le fichier final
            $formView = $form->createView();

            //on rend la vue
            return $this->render('admin/contacts/contactAdd.html.twig', array('form'=>$formView, 'entreprise' => $entreprise));
    }

    /**
     * @param Contacts $contact
     * @param SessionInterface $session
     * @param ObjectManager $em
     * @return Response
     * @Route("/admin/contacts/{id}/deleteContact", name="deleteContact")
     * @IsGranted("ROLE_RESPSTAGES")
     */
    public function delete(Contacts $contact, SessionInterface $session, ObjectManager $em){
        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);

        // recupere l'entreprise avec l'id stocké en session
        $entreprise = $repository->find($session->get('entreprise'));

        // On supprime et sauvegarde modifications
        $em->remove($contact);
        $em->flush();

        // On affiche message de validation dans le formulaire de redirection
        $this->get('session')->getFlashBag()->add('notice','Le contact (' . $contact->getNomcontact() . ' ' . $contact->getPrenomcontact() . ') à été supprimé !');

        //Retourne form de la liste des contact de l'entreprise
        return $this->redirectToRoute('showContacts', ['id' => $entreprise->getCodeentreprise()]);

    }

    /**
     * @Route("/entreprises/{id}/contacts", name="showContacts")
     * @IsGranted("ROLE_RESPSTAGES")
     * @param Entreprises $entreprise
     * @param SessionInterface $session
     * @return Response
     */
    public function showContacts(Entreprises $entreprise, SessionInterface $session){
       // On verifie si il y a deja une entreprise en session :
        // si elle est différente de l'entreprise actuelle on ecrase l'ancienne valeur
        // si elle est identique on ne fais rien
        if($session->get('entreprise') != $entreprise->getCodeentreprise()){
            $session->set('entreprise',$entreprise->getCodeentreprise());
        }
        $repository = $this->getDoctrine()
            ->getRepository(Contacts::class);
        // recupere l'entreprise avec l'id stocké en session
        $contacts = $repository->createQueryBuilder('c')
            ->where('c.codeentreprise = :entreprise')
            ->setParameter('entreprise', $session->get('entreprise'))
            ->getQuery()
            ->getResult();

        return $this->render('admin/contacts/contactsShow.html.twig',['contacts' => $contacts, 'entreprise' => $entreprise]);

    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $em
     * @return Response
     * @Route("/contacts/inscrire/{codeInscription}", name="inscrireContact")
     */
    public function inscrire(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $em)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Contacts::class);
        $contact = $repository->createQueryBuilder('c')
            ->where('c.codeInscription = :codeInscription')
            ->setParameter('codeInscription', $request->get('codeInscription'))
            ->getQuery()
            ->getOneOrNullResult();

        $form = $this->createForm(ContactInscriptionType::class, $contact);
        $form->handleRequest($request);

        if ($contact->getMdpcontact() != null) {
            $this->get('session')->getFlashBag()->add('error', 'Inscription déjà effectuée !');
            return $this->redirect($this->generateUrl('homepage'));
        } else {
            //si le formulaire a été soumis
            if ($form->isSubmitted() && $form->isValid()) {

                //on enregistre le mdp du contact dans la bdd
                $hash = $encoder->encodePassword($contact, $request->get('password'));
                $contact->setMdpcontact($hash);
                $em->flush();

                // On affiche message de validation dans le formulaire de redirection
                $this->get('session')->getFlashBag()->add('notice', 'Inscription effectuée !');

                //Retour a l'accueil
                return $this->redirect($this->generateUrl('homepage'));
            }

            //On génére le fichier final
            $formView = $form->createView();

            //on rend la vue
            return $this->render('/contacts/inscription.html.twig', array('form' => $formView, 'contact' => $contact));
        }

    }
}
