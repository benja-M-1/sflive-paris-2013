<?php

namespace Theodo\Bundle\ExpertBundle\Tests\Controller;

use Theodo\Bundle\ExpertBundle\Tests\WebTestCase;

/**
 * ExpertControllerTest
 * 
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 * @group functional
 */
class ExpertControllerTest extends WebTestCase
{
    public function testShouldDisplayTheExpertsList()
    {
        $client = self::createClient();

        $loader    = new \Nelmio\Alice\Loader\Base();
        $objects   = $loader->load($this->getExperts());
        $persister = new \Nelmio\Alice\ORM\Doctrine(static::$kernel->getContainer()->get('doctrine.orm.entity_manager'));
        $persister->persist($objects);

        $crawler = $client->request('GET', '/experts');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(1, $crawler->filter('li')->count());
        $this->assertCount(1, $crawler->filter('form'));
    }

    private function getExperts()
    {
        return array(
            'Theodo\Bundle\ExpertBundle\Entity\Expert' => array(
                'expert{1..5}' => array(
                    'firstName' => '<firstName()>',
                    'lastName'  => '<lastName()>',
                    'username'  => '<userName()>'
                ),
            )
        );
    }

    public function testShouldSaveANewExpert()
    {
        $client = self::createClient();

        $csrfToken = $client->getContainer()->get('form.csrf_provider')->generateCsrfToken('unknown');
        $client->request('POST', '/experts', array(
            'form' => array(
                'firstName' => 'Benjamin',
                'lastName'  => 'Grandfond',
                'username'  => 'benjaming',
                '_token'    => $csrfToken,
            )
        ));

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertEquals("/experts", $client->getResponse()->getTargetUrl());

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('ul li'));
        $this->assertRegExp('~Benjamin~', $crawler->filter('li')->text());
        $this->assertCount(1, $crawler->filter('form'));
    }

    /*

    public function testShouldDisplayTheFormWithErrors()
    {
        $client = self::createClient();
        self::generateSchema();

        $crawler = $client->request('POST', '/experts');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('form > ul'));
    }*/
}
