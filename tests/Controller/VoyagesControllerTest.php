<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class VoyagesControllerTest extends WebTestCase
{
    public function testAccesPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testContenuPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');
        $this->assertSelectorTextContains('h1', 'Mes voyages');
        $this->assertSelectorTextContains('th', 'Ville');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'paris');
    }

    public function testLinkVille(): void
    {
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $client->clickLink('paris');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/voyages/voyage/1', $uri);
    }

    public function testFiltreVille(): void
    {
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'paris'
        ]);
        $this->assertCount(6, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'paris');
    }
}