<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{

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
    #[Route('/task/{id}/{statut}/remove', name: 'project_task_remove')]
    public function taskRemove(int $id, int $statut): Response
    {
        /// ajout de la suppression
        return $this->redirectToRoute('project_id', ['id' => $id, 'statut' => $statut]);
    }
}
