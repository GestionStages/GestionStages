<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @Route("/auth/student", name="connectEtudiant")
     * @param Request $request
     * @return Response
     */
    public function authStudentAction(Request $request) {
        $username = $request->get('_username');
        $password = $request->get('_password');
        $group = $request->get('group');

        if (!is_null($username) && !is_null($password) && !is_null($group)) {
            $conn  = ldap_connect($this->getParameter('ldap_host'), $this->getParameter('ldap_port'));
            ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

            $dn = str_replace(
                ["{username}", "{group}"],
                [ldap_escape($username, null, LDAP_ESCAPE_FILTER), ldap_escape($group, null, LDAP_ESCAPE_FILTER)],
                "uid={username},ou={group},ou=Etudiants,".$this->getParameter("ldap_base_dn")
            );

            if (!@ldap_bind($conn, $dn, $password)) {
                return $this->render(':default:index.html.twig', [
                    'last_username' => $username,
                    'error' => "Informations de connexion incorrectes !"
                ]);
            }

            //TODO: Récupérer l'utilisateur & le connecter

            return $this->redirectToRoute('homepage');
        }

        return $this->render('auth/students.html.twig', [
            'last_username' => $username
        ]);
    }
}
