<?php

namespace AppBundle\Tests\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Entreprises;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Propositions;

class PropositionsRepositoryTest extends WebTestCase
{
    public function testnbEnAttenteValid()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $em = $container->get('doctrine')->getManager();
        $entities = $em->getRepository('AppBundle:Propositions')->nbEnAttenteValid();
        $this->assertEquals($entities, 2);

    }

    public function testnbValid()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $em = $container->get('doctrine')->getManager();
        $entities = $em->getRepository('AppBundle:Propositions')->nbValid();
        $this->assertEquals($entities, 1);

    }

    public function testnbAffecte()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $em = $container->get('doctrine')->getManager();
        $entities = $em->getRepository('AppBundle:Propositions')->nbAffecte();
        $this->assertEquals($entities, 1);

    }

    public function testnbArchive()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $em = $container->get('doctrine')->getManager();
        $entities = $em->getRepository('AppBundle:Propositions')->nbArchive();
        $this->assertEquals($entities, 1);

    }

    public function testnbRefuse()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $em = $container->get('doctrine')->getManager();
        $entities = $em->getRepository('AppBundle:Propositions')->nbRefuse();
        $this->assertEquals($entities, 1);

    }
}
