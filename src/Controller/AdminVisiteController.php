<?php
namespace App\Controller;

use App\Entity\Visite;
use App\Form\VisiteType;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/visite')]
final class AdminVisiteController extends AbstractController
{
    private VisiteRepository $repository;

    public function __construct(VisiteRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route(name: 'app_admin_visite_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin_visite/index.html.twig', [
            'visites' => $this->repository->findAllOrderBy('datecreation', 'DESC'),
        ]);
    }

    #[Route('/new', name: 'app_admin_visite_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move(
                    $this->getParameter('kernel.project_dir') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'photos',
                    $newFilename
                );
                $visite->setPhoto($newFilename);
            }
            $this->repository->add($visite);
            return $this->redirectToRoute('app_admin_visite_index');
        }

        return $this->render('admin_visite/new.html.twig', [
            'visite' => $visite,
            'form' => $form,
        ]);
    }

    #[Route('/suppr/{id}', name: 'app_admin_visite_delete', methods: ['GET'])]
    public function delete(int $id): Response
    {
        $visite = $this->repository->find($id);
        $this->repository->remove($visite);
        return $this->redirectToRoute('app_admin_visite_index');
    }

    #[Route('/{id}', name: 'app_admin_visite_show', methods: ['GET'])]
    public function show(Visite $visite): Response
    {
        return $this->render('admin_visite/show.html.twig', [
            'visite' => $visite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_visite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Visite $visite): Response
    {
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/photos',
                    $newFilename
                );
                $visite->setPhoto($newFilename);
            }
            $this->repository->add($visite);
            return $this->redirectToRoute('app_admin_visite_index');
        }

        return $this->render('admin_visite/edit.html.twig', [
            'visite' => $visite,
            'form' => $form,
        ]);
    }
}