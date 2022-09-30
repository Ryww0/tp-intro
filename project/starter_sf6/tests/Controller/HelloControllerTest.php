<?php

namespace App\Tests\Controller;

use App\Controller\HelloController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HelloControllerTest extends WebTestCase
{
    public function testHelloRandomRoute()
    {
        $client = static::createClient();

        $crawler = $client->request("GET", "/helloRandom");

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Hello ", $crawler->filter("h1")->text());
    }

    function testRandomNameGenerator()
    {
        $rdName = HelloController::generateRandomName();
        $this->assertGreaterThan(1, strlen($rdName));
    }

    function testNameAction()
    {
        $client = static::createClient();

        $crawler = $client->request("GET", "/hello/jack");
        $this->assertStringContainsString('Hello jack', $crawler->filter("h1")->text());
    }

    function testWhenNameIsEmptyAndSessionIsNotEmpty(SessionInterface $session)
    {
        $client = static::createClient();
        $crawler = $client->request("GET", "/hello");
        $session->set('name', 'jack');
        if ($session->get('name')) {
            $this->assertStringContainsString('Hello jack', $crawler->filter("h1")->text());
        }
    }
}