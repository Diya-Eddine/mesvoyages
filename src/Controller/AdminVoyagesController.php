<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminVoyagesController extends AbstractController {

    #[Route('/admin/voyages', name: 'admin_voyages')]
    public function index(): Response {
        return $this->render("admin/voyages.html.twig");
    }
}