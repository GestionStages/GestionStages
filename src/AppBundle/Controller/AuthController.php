<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etudiant;
use AppBundle\Entity\Professeur;
use AppBundle\Entity\RolesProf;
use AppBundle\Form\EtudiantType;
use AppBundle\Form\ProfesseurType;
use AppBundle\Repository\EtudiantRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AuthController extends Controller
{
    /**
     * @Route("/auth/etu/inscription", name="inscriptEtu")
     * @param Request $request
     * @param ObjectManager $em
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function inscriptionEtu(Request $request, ObjectManager $em, UserPasswordEncoderInterface $encoder, EtudiantRepository $repository) {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant, ['validation_groups' => ['inscription', 'Default']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $etudiant->getUserEtudiant();

            $dbResult = $repository->findOneByUserEtudiant($username);
            if (!is_null($dbResult)) {
                $this->get('session')->getFlashBag()->add('error', "Cet utilisateur existe déjà, essayez de vous connecter");
                return $this->redirectToRoute('connectEtu');
            }

            $group = $etudiant->getCodeclasse()->getCodegroupeldap()->getLdapSection();

            //Initialisation de la connexion au serveur LDAP
            $conn  = ldap_connect($this->getParameter('ldap_host'), $this->getParameter('ldap_port'));
            ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

            //On construit et sécurise les paramètres de recherche
            $uid = "uid=".ldap_escape($username, null, LDAP_ESCAPE_FILTER);
            $ouGroup = "ou=".ldap_escape($group, null, LDAP_ESCAPE_FILTER);

            //On construit le chemin vers le dossier de la classe
            $dn = $ouGroup.",ou=Etudiants,".$this->getParameter("ldap_base_dn");

            //On accède au dossier
            $search = @ldap_list($conn, $dn, $uid);
            if (!$search) {
                return $this->render('login/students.html.twig', [
                    'last_username' => $username,
                    'error' => "Informations de connexion incorrectes !"
                ]);
            }

            //On cherche l'utilisateur
            $user_data = ldap_get_entries($conn, $search);
            if (count($user_data) == 0) {
                return $this->render('inscription/students.html.twig', [
                    'last_username' => $username,
                    'error' => "Informations de connexion incorrectes !"
                ]);
            }
            $user_data = $user_data[0]; //On garde que la première entrée

            //On construit le chemin vers l'utilisateur
            $dn = $uid.",".$dn;

            //On vérifie les informations de connexion de l'utilisateur
            if (!@ldap_bind($conn, $dn, $etudiant->getPassword())) {
                return $this->render('inscription/students.html.twig', [
                    'last_username' => $username,
                    'error' => "Informations de connexion incorrectes !"
                ]);
            }

            $etudiant->setNomEtudiant($user_data['givenname'][0]);
            $etudiant->setPrenomEtudiant($user_data['sn'][0]);
            $etudiant->setMailEtudiant($user_data['mail'][0]);
            $etudiant->setPassEtudiant($encoder->encodePassword($etudiant, $etudiant->getPassword()));

            $em->persist($etudiant);
            $em->flush();

            // Connexion automatique
            $token = new UsernamePasswordToken($etudiant, null, 'main', $etudiant->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $this->redirectToRoute('homepage');
        }

        $formview = $form->createView();

        return $this->render("inscription/students.html.twig", [
            'form' => $formview
        ]);
    }

    /**
     * @Route("/auth/prof/inscription", name="inscriptProf")
     * @param Request $request
     * @param ObjectManager $em
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function inscriptionProf(Request $request, ObjectManager $em, UserPasswordEncoderInterface $encoder) {
        $professeur = new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $professeur->getUsername();

            $dbResult = $this->getDoctrine()->getRepository(Professeur::class)
                ->findOneByUserProf($username);

            if (!is_null($dbResult)) {
                $this->get('session')->getFlashBag()->add('error', "Cet utilisateur existe déjà, essayez de vous connecter");
                return $this->redirectToRoute('connectProf');
            }

            //Initialisation de la connexion au serveur LDAP
            $conn  = ldap_connect($this->getParameter('ldap_host'), $this->getParameter('ldap_port'));
            ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

            //On construit et sécurise les paramètres de recherche
            $uid = "uid=".ldap_escape($username, null, LDAP_ESCAPE_FILTER);

            //On construit le chemin vers le dossier de la classe
            $dn = "ou=Personnel,".$this->getParameter("ldap_base_dn");

            //On accède au dossier
            $search = @ldap_list($conn, $dn, $uid);
            if (!$search) {
                return $this->render('inscription/teachers.html.twig', [
                    'error' => "Informations de connexion incorrectes !"
                ]);
            }

            //On cherche l'utilisateur
            $user_data = ldap_get_entries($conn, $search);
            if (count($user_data) == 0) {
                return $this->render('inscription/teachers.html.twig', [
                    'error' => "Informations de connexion incorrectes !"
                ]);
            }
            $user_data = $user_data[0]; //On garde que la première entrée

            //On construit le chemin vers l'utilisateur
            $dn = $uid.",".$dn;

            //On vérifie les informations de connexion de l'utilisateur
            if (!@ldap_bind($conn, $dn, $professeur->getPassword())) {
                return $this->render('inscription/teachers.html.twig', [
                    'error' => "Informations de connexion incorrectes !"
                ]);
            }

            $role = $this->getDoctrine()->getRepository(RolesProf::class)
                         ->findOneByCodeRole(1);

            $professeur->setNomProf($user_data['givenname'][0]);
            $professeur->setPrenomProf($user_data['sn'][0]);
            $professeur->setMailProf($user_data['mail'][0]);
            $professeur->setPassProf($encoder->encodePassword($professeur, $professeur->getPassword()));
            $professeur->setRoleProf($role);

            $em->persist($professeur);
            $em->flush();

            // Connexion automatique
            $this->manualLogin($request, $professeur);
            return $this->redirectToRoute('homepage');
        }

        $formview = $form->createView();

        return $this->render("inscription/teachers.html.twig", [
            'form' => $formview
        ]);
    }

    /**
     * @Route("/auth/etu/connexion", name="connectEtu")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function loginEtu(Request $request, UserPasswordEncoderInterface $encoder) {
        $username = "";
        $error = null;

        // Si le formulaire est transmit
        if ($request->request->count()) {
            try {
                $username = $request->request->get('_username');
                $password = $request->request->get('_password');

                /** @var Etudiant $etudiant */
                $etudiant = $this->getDoctrine()->getRepository(Etudiant::class)
                                 ->findOneByUserEtudiant($username);

                if (is_null($etudiant)) {
                    throw new AuthenticationException();
                }

                if (!$encoder->isPasswordValid($etudiant, $password)) {
                    throw new AuthenticationException();
                }

                $this->manualLogin($request, $etudiant);
                return $this->redirectToRoute('homepage');
            } catch (AuthenticationException $exception) {
                $error = "Informations de connexion incorrectes";
            }
        }

        return $this->render('login/iut.html.twig', [
            'error' => $error,
            'last_username' => $username
        ]);
    }

    /**
     * @Route("/auth/prof/connexion", name="connectProf")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function loginProf(Request $request, UserPasswordEncoderInterface $encoder) {
        $username = "";
        $error = null;

        // Si le formulaire est transmit
        if ($request->request->count()) {
            try {
                $username = $request->request->get('_username');
                $password = $request->request->get('_password');

                /** @var Professeur $professeur */
                $professeur = $this->getDoctrine()->getRepository(Professeur::class)
                    ->findOneByUserProf($username);

                if (is_null($professeur)) {
                    throw new AuthenticationException();
                }

                if (!$encoder->isPasswordValid($professeur, $password)) {
                    throw new AuthenticationException();
                }

                $this->manualLogin($request, $professeur);
                return $this->redirectToRoute('homepage');
            } catch (AuthenticationException $exception) {
                $error = "Informations de connexion incorrectes";
            }
        }

        return $this->render('login/iut.html.twig', [
            'error' => $error,
            'last_username' => $username
        ]);
    }

    /**
     * @Route("/auth/logout", name="logout")
     */
    public function logout() {
        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();
        return $this->redirectToRoute('homepage');
    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @param string $redirectRoute
     */
    private function manualLogin(Request $request, UserInterface $user, $redirectRoute = 'homepage')
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));

        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
    }

    /**
     * @param $username
     * @param $password
     * @param $group Null pour les profs
     * @return array
     */
    private function ldapFetch($username, $password, $group = null)
    {
        //Initialisation de la connexion au serveur LDAP
        $conn = ldap_connect($this->getParameter('ldap_host'), $this->getParameter('ldap_port'));
        ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

        //On construit et sécurise les paramètres de recherche
        $uid = "uid=" . ldap_escape($username, null, LDAP_ESCAPE_FILTER);

        if (!is_null($group)) {
            $ouGroup = "ou=".ldap_escape($group, null, LDAP_ESCAPE_FILTER);

            //On construit le chemin vers le dossier de la classe
            $dn = $ouGroup.",ou=Etudiants,".$this->getParameter("ldap_base_dn");
        } else {
            //On construit le chemin vers le dossier de la classe
            $dn = "ou=Personnel,".$this->getParameter("ldap_base_dn");
        }

        //On accède au dossier
        $search = @ldap_list($conn, $dn, $uid);
        if (!$search) {
            throw new AuthenticationException();
        }

        //On cherche l'utilisateur
        $user_data = ldap_get_entries($conn, $search);
        if (count($user_data) == 0) {
            throw new AuthenticationException();
        }
        $user_data = $user_data[0]; //On garde que la première entrée

        //On construit le chemin vers l'utilisateur
        $dn = $uid.",".$dn;

        //On vérifie les informations de connexion de l'utilisateur
        if (!@ldap_bind($conn, $dn, $password)) {
            throw new AuthenticationException();
        }

        return $user_data;
    }
}
