<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController {

    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response {
        $sent = false;
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $email = $request->request->get('email');
            $message = $request->request->get('message');
            $sent = true;
        }
        return $this->render("pages/contact.html.twig", [
            'sent' => $sent
        ]);
    }
}