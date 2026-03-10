<?php
namespace App\Tests\Repository;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VisiteRepositoryTest extends KernelTestCase
{
    public function recupRepository(): VisiteRepository
    {
        self::bootKernel();
        $repository = self::getContainer()->get(VisiteRepository::class);
        return $repository;
    }

    public function newVisite(): Visite
    {
        return (new Visite())
            ->setVille("VilleTest123")
            ->setPays("USA")
            ->setDatecreation(new \DateTime("now"));
    }

    public function testNbVisites(): void
    {
        $repository = $this->recupRepository();
        $nbVisites = $repository->count([]);
        $this->assertEquals(10, $nbVisites);
    }

    public function testAddVisite(): void
    {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $nbVisites = $repository->count([]);
        $repository->add($visite);
        $this->assertEquals($nbVisites + 1, $repository->count([]), "erreur lors de l'ajout");
    }

    public function testRemoveVisite(): void
    {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite);
        $nbVisites = $repository->count([]);
        $repository->remove($visite);
        $this->assertEquals($nbVisites - 1, $repository->count([]), "erreur lors de la suppression");
    }

    public function testFindByEqualValue(): void
    {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite);
        $visites = $repository->findByEqualValue("ville", "VilleTest123");
        $nbVisites = count($visites);
        $this->assertEquals(1, $nbVisites);
        $this->assertEquals("VilleTest123", $visites[0]->getVille());
    }
}