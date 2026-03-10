<?php
namespace App\Tests\Validations;
use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
class VisiteValidationsTest extends KernelTestCase
{
    public function getVisite(): Visite
    {
        return (new Visite())
            ->setVille("New York")
            ->setPays("USA");
    }
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message = ""): void
    {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    public function testValidNoteVisite(): void
    {
        $visite = $this->getVisite()->setNote(10);
        $this->assertErrors($visite, 0);
    }
    public function testNonValidNoteVisite(): void
    {
        $visite = $this->getVisite()->setNote(21);
        $this->assertErrors($visite, 1);
    }
    public function testNoteMinVisite(): void
    {
        $visite = $this->getVisite()->setNote(0);
        $this->assertErrors($visite, 0, "note=0 (limite basse) devrait être valide");
    }
    public function testNoteMaxVisite(): void
    {
        $visite = $this->getVisite()->setNote(20);
        $this->assertErrors($visite, 0, "note=20 (limite haute) devrait être valide");
    }
    public function testNoteNegativeVisite(): void
    {
        $visite = $this->getVisite()->setNote(-1);
        $this->assertErrors($visite, 1, "note=-1 devrait échouer");
    }
    public function testNonValidTempmaxVisite(): void
    {
        $visite = $this->getVisite()
            ->setTempmin(20)
            ->setTempmax(18);
        $this->assertErrors($visite, 1, "min=20, max=18 devrait échouer");
    }
    public function testDatecreationAujourdhui(): void
    {
        $visite = $this->getVisite();
        $visite->setDatecreation(new \DateTime("today"));
        $this->assertErrors($visite, 0, "datecreation=aujourd'hui devrait être valide");
    }
    public function testDatecreationPassee(): void
    {
        $visite = $this->getVisite();
        $visite->setDatecreation(new \DateTime("2020-01-01"));
        $this->assertErrors($visite, 0, "datecreation passée devrait être valide");
    }
    public function testDatecreationFuture(): void
    {
        $visite = $this->getVisite();
        $visite->setDatecreation(new \DateTime("tomorrow"));
        $this->assertErrors($visite, 1, "datecreation future devrait échouer");
    }
}