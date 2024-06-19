<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
    
    #[Route('/task/{id}/{statut}/add', name: 'project_task_add')]
    public function taskFormAdd(request $request, int $id, int $statut): Response
    {
        return $this->render('task/form.html.twig', [
            'current_route' => $request->attributes->get('_route'), 
            'id' => $id,
            'statut' => $statut
        ]);
    }
    #[Route('/task/{id}/{taskId}/edit', name: 'project_task_edit')]
    public function taskFormEdit(request $request, int $id, int $taskId): Response
    {
        return $this->render('task/form.html.twig', [
            'current_route' => $request->attributes->get('_route'), 
            'id' => $id,
            'statut' => $taskId
        ]);
    }
}
