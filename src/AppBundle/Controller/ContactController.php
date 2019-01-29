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
use AppBundle\Form\EntreprisesType;
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
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @param Request $request
     * @param SessionInterface $session
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function addAction(Request $request, SessionInterface $session, \Swift_Mailer $mailer)
    {

        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);
//TODO: A Déplacer dans repository EntrepriseRepository
        //recuperation de l'entreprise par l'id passer en session
        $entreprise = $repository->createQueryBuilder('e')
            ->where('e.codeentreprise = :entreprise')
            ->setParameter('entreprise', $session->get('entreprise'))
            ->getQuery()
            // Cette ligne permet de récupérer directement l'objet et non un tableau avec l'objet à l'interieur
            ->getOneOrNullResult();


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
            $em = $this-> getDoctrine()->getManager();
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
     * @return Response
     * @Route("/admin/contacts/{id}/edit", name="editContact")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function edit(Request $request, Contacts $contact, SessionInterface $session){
        $form = $this->createForm(ContactsType::class, $contact);

            $form->handleRequest($request);

        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);

//TODO: A Déplacer dans repository EntrepriseRepository
        $entreprise = $repository->createQueryBuilder('e')
            ->where('e.codeentreprise = :entreprise')
            ->setParameter('entreprise', $session->get('entreprise'))
            ->getQuery()
            // Cette ligne permet de récupérer directement l'objet et non un tableau avec l'objet à l'interieur
            ->getOneOrNullResult();

        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid()){
            //on enregistre l'entreprise dans la bdd
            $em = $this-> getDoctrine()->getManager();
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
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Route("/admin/contacts/{id}/deleteContact", name="deleteContact")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function delete(Contacts $contact, SessionInterface $session){
        //TODO: A Déplacer dans repository EntrepriseRepository
        $repository = $this->getDoctrine()
            ->getRepository(Entreprises::class);
        // recupere l'entreprise avec l'id stocké en session
        $entreprise = $repository->createQueryBuilder('e')
            ->where('e.codeentreprise = :entreprise')
            ->setParameter('entreprise', $session->get('entreprise') )
            ->getQuery()
           // Cette ligne permet de récupérer directement l'objet et non un tableau avec l'objet à l'interieur
            ->getOneOrNullResult();

        // On supprime et sauvegarde modifications
        $em = $this-> getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        // On affiche message de validation dans le formulaire de redirection
        $this->get('session')->getFlashBag()->add('notice','Le contact (' . $contact->getNomcontact() . ' ' . $contact->getPrenomcontact() . ') à été supprimé !');

        //Retourne form de la liste des contact de l'entreprise
        return $this->redirectToRoute('showContacts', ['id' => $entreprise->getCodeentreprise()]);

    }

    /**
     * @Route("/entreprises/{id}/contacts", name="showContacts")
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
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
     * @return Response
     * @Route("/contacts/inscrire/{codeInscription}", name="inscrireContact")
     */
    public function inscrire(Request $request, UserPasswordEncoderInterface $encoder)
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
                $em = $this->getDoctrine()->getManager();
                $hash = $encoder->encodePassword($contact, $request->get('password'));
                $contact->setMdpcontact($hash);
                $em->persist($contact);
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
