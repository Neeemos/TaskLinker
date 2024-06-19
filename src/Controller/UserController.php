<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_list')]
    public function index(request $request): Response
    {
        return $this->render('user/index.html.twig', [
            'current_route' => $request->attributes->get('_route'),
        ]);
    }
    #[Route('/user/{id}/edit', name: 'user_edit')]
    public function edit(request $request, int $id): Response
    {
        return $this->render('user/user.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'id' => $id
        ]);
    }
}
