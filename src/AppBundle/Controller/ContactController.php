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
use AppBundle\Form\ContactsType;
use AppBundle\Form\EntreprisesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class ContactController extends Controller

{
    /**
     *
     * @Route("/admin/contact/add", name="addContact")
     *
     * @param Request $request
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function addAction(Request $request,SessionInterface $session)
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
        // On affecte l'entreprise au contact
        $entreprise->addCodeContact($contact);


        //On récupère le form
        $form = $this->createForm(ContactsType::class, $contact);

        $form->handleRequest($request);

        //si le formulaire a été soumis

        if($form->isSubmitted() && $form->isValid()){

            $transport = \Swift_SmtpTransport::newInstance()
                ->setUsername('axel_titan@hotmail.fr')
                ->setPassword('titan2008')
                ->setHost('smtp.live.com')
                ->setPort(465)->setEncryption('tls');

            $mailer = \Swift_Mailer::newInstance($transport);

            $message = \Swift_Message::newInstance()
                ->setSubject('Demande d\'inscription sur la plateforme de l\'IUT de Montpellier')
                ->setFrom('axel.commergnat@hotmail.com')
                ->setTo('axel_titan@hotmail.fr')
                ->addPart("<h1>Votre entreprise vous a Inscrit sur notre plateforme de gestions de stages</h1>",'text/html')
            ;

            $result = $mailer->send($message);
            //on enregistre le contact dans la bdd
            $em = $this-> getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            // On affiche message de validation dans le formulaire de redirection
            $this->get('session')->getFlashBag()->add('notice','Le contact ('.$contact->getNomcontact(). " " . $contact->getPrenomcontact() . ') est ajouté !');

            //Retourne form de la liste des contacts de l'entreprise
            return $this->redirectToRoute('showContacts',['id' => $entreprise->getCodeEntreprise()]);

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
                return $this->redirectToRoute('showContacts',['id' => $entreprise->getCodeEntreprise()]);

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
     * @Route("/admin/contacts/{id}/deleteContact", name="deleteContact")
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
        return $this->render('admin/contacts/contactsShow.html.twig', ['contacts'=>$entreprise->getCodecontact(), 'entreprise' => $entreprise] );

    }

    /**
     *
     * @Route("/entreprises/{id}/contacts", name="showContacts")
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

        $repository = $this->getDoctrine()->getRepository(Contacts::class);
        $contacts = [];
        foreach ($entreprise->getCodecontact() as $contact) {
            $contacts[] = $repository->find($contact->getCodeContact());
        }

        return $this->render('admin/contacts/contactsShow.html.twig',['contacts' => $contacts, 'entreprise' => $entreprise]);

    }
    /**
     * @param Request $request
     * @return Response
     * @Route("/contacts/{id}/inscrire", name="inscireContact")
     */
    public function inscrire(Request $request){


        $contact = $this->getDoctrine()->getRepository(Contacts::class)->find($request->get('id'));
        if($contact->getMdpcontact() != null){
            $this->get('session')->getFlashBag()->add('error','Inscription déjà effectuée !');
            return $this->redirect($this->generateUrl('homepage'));
        }
        else{
            if(!$request->get('password')){

                return $this->render('/contacts/inscription.html.twig', ['contact' => $contact]);
            }
            else{
                if($request->get('password') != $request->get('password2')){
                    $this->get('session')->getFlashBag()->add('error','Mots de passe différents');
                    return $this->render('/contacts/inscription.html.twig', ['contact' => $contact]);
                }
                else{
                    $contact->setMdpContact($request->get('password'));

                    $em = $this-> getDoctrine()->getManager();
                    $em->persist($contact);
                    $em->flush();

                    // On affiche message de validation dans le formulaire de redirection
                    $this->get('session')->getFlashBag()->add('notice','Inscription enregistée !');
                    return $this->redirect($this->generateUrl('homepage'));
                }
            }
        }
    }


}
