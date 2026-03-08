<?php
namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController {

    #[Route('/', name: 'accueil')]
    public function index(VisiteRepository $repo): Response {
        $visites = $repo->findBy([], ['date' => 'DESC'], 2);
        return $this->render("pages/accueil.html.twig", [
            'visites' => $visites
        ]);
    }
}