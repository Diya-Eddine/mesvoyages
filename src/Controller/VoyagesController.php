<?php
namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoyagesController extends AbstractController {

    #[Route('/voyages', name: 'voyages')]
    public function index(VisiteRepository $repo): Response {
        $visites = $repo->findAll();
        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]);
    }

    #[Route('/voyage/{id}', name: 'detail_voyage')]
    public function detail(int $id, VisiteRepository $repo): Response {
        $visite = $repo->find($id);
        return $this->render("pages/detail.html.twig", [
            'visite' => $visite
        ]);
    }
}