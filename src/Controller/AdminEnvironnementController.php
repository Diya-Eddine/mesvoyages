<?php
namespace App\Controller;

use App\Entity\Environnement;
use App\Form\EnvironnementType;
use App\Repository\EnvironnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/environnement')]
final class AdminEnvironnementController extends AbstractController
{
    private EnvironnementRepository $repository;

    public function __construct(EnvironnementRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route(name: 'app_admin_environnement_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin_environnement/index.html.twig', [
            'environnements' => $this->repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_environnement_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $environnement = new Environnement();
        $form = $this->createForm(EnvironnementType::class, $environnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($environnement);
            return $this->redirectToRoute('app_admin_environnement_index');
        }

        return $this->render('admin_environnement/new.html.twig', [
            'environnement' => $environnement,
            'form' => $form,
        ]);
    }

    #[Route('/suppr/{id}', name: 'app_admin_environnement_delete', methods: ['GET'])]
    public function delete(int $id): Response
    {
        $environnement = $this->repository->find($id);
        $this->repository->remove($environnement);
        return $this->redirectToRoute('app_admin_environnement_index');
    }

    #[Route('/{id}/edit', name: 'app_admin_environnement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Environnement $environnement): Response
    {
        $form = $this->createForm(EnvironnementType::class, $environnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($environnement);
            return $this->redirectToRoute('app_admin_environnement_index');
        }

        return $this->render('admin_environnement/edit.html.twig', [
            'environnement' => $environnement,
            'form' => $form,
        ]);
    }
}