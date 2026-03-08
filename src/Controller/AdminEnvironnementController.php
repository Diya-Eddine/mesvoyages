<?php

namespace App\Controller;

use App\Entity\Environnement;
use App\Form\EnvironnementType;
use App\Repository\EnvironnementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/environnement')]
final class AdminEnvironnementController extends AbstractController
{
    #[Route(name: 'app_admin_environnement_index', methods: ['GET'])]
    public function index(EnvironnementRepository $environnementRepository): Response
    {
        return $this->render('admin_environnement/index.html.twig', [
            'environnements' => $environnementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_environnement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $environnement = new Environnement();
        $form = $this->createForm(EnvironnementType::class, $environnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($environnement);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_environnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_environnement/new.html.twig', [
            'environnement' => $environnement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_environnement_show', methods: ['GET'])]
    public function show(Environnement $environnement): Response
    {
        return $this->render('admin_environnement/show.html.twig', [
            'environnement' => $environnement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_environnement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Environnement $environnement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnvironnementType::class, $environnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_environnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_environnement/edit.html.twig', [
            'environnement' => $environnement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_environnement_delete', methods: ['POST'])]
    public function delete(Request $request, Environnement $environnement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$environnement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($environnement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_environnement_index', [], Response::HTTP_SEE_OTHER);
    }
}
