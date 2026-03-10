<?php
namespace App\Tests;

use App\Entity\Visite;
use PHPUnit\Framework\TestCase;

class VisiteTest extends TestCase
{
    public function testGetDatecreationString(): void
    {
        $visite = new Visite();
        $visite->setDatecreation(new \DateTime("2024-04-24"));
        $this->assertEquals("24/04/2024", $visite->getDatecreationString());
    }
}