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
}
