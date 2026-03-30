<?php
namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VoyagesController extends AbstractController
{
    private const VOYAGES_TEMPLATE = "pages/voyages.html.twig";
    private $repository;

    public function __construct(VisiteRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/voyages', name: 'voyages')]
    public function index(): Response
    {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render(self::VOYAGES_TEMPLATE, [
            'visites' => $visites
        ]);
    }

    #[Route('/voyages/tri/{champ}/{ordre}', name: 'voyages.sort')]
    public function sort(string $champ, string $ordre): Response
    {
        $visites = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render(self::VOYAGES_TEMPLATE, [
            'visites' => $visites
        ]);
    }

    #[Route('/voyages/recherche/{champ}', name: 'voyages.findallequal')]
    #[Route('/voyages/recherche/environnement', name: 'voyages.findbyenv')]
    public function findByEnvironnement(Request $request): Response
    {
        if ($this->isCsrfTokenValid('filtre_environnement', $request->get('_token'))) {
            $valeur = $request->get("recherche");
            if ($valeur) {
                $visites = $this->repository->findByEnvironnement($valeur);
            } else {
                $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
            }
            return $this->render(self::VOYAGES_TEMPLATE, [
                'visites' => $visites
            ]);
        }
        return $this->redirectToRoute("voyages");
    }

    public function findAllEqual(string $champ, Request $request): Response
    {
        if ($this->isCsrfTokenValid('filtre_' . $champ, $request->get('_token'))) {
            $valeur = $request->get("recherche");
            $visites = $this->repository->findByEqualValue($champ, $valeur);
            return $this->render(self::VOYAGES_TEMPLATE, [
                'visites' => $visites
            ]);
        }
        return $this->redirectToRoute("voyages");
    }

    #[Route('/voyages/voyage/{id}', name: 'voyages.showone')]
    public function showOne(int $id): Response
    {
        $visite = $this->repository->find($id);
        return $this->render("pages/detail.html.twig", [
            'visite' => $visite
        ]);
    }
}