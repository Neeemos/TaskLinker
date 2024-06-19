<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends AbstractController
{
    #[Route('/', name: 'project_index')]
    public function index(request $request): Response
    {
        return $this->render('project/index.html.twig', [
            'current_route' => $request->attributes->get('_route'),
        ]);
    }


    #[Route('/project/form/', name: 'project_form')]
    public function projectFormAdd(request $request): Response
    {
        return $this->render('project/form.html.twig', [
            'current_route' => $request->attributes->get('_route')
        ]);
    }
    #[Route('/project/form/{id}', name: 'project_form_id')]
    public function projectFormEdit(request $request, int $id): Response
    {
        return $this->render('project/form.html.twig', [
            'current_route' => $request->attributes->get('_route'), 
            'id' => $id
        ]);
    }
    #[Route('/project/edit/{id}', name: 'project_edit')]
    public function projectEdit(request $request, int $id): Response
    {
        return $this->render('project/project.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'id' => $id
        ]);
    }
    #[Route('/project/remove/{id}', name: 'project_remove')]
    public function projectRemove(request $request, int $id): Response
    {
        /// ajout de la suppression
        return $this->redirectToRoute('project_index');
    }
    
    #[Route('/project/manager/{id}', name: 'project_id')]
    public function projectFind(request $request, int $id): Response
    {
        return $this->render('project/project.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'id' => $id
        ]);
    }
}
