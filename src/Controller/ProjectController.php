<?php

namespace App\Controller;

use App\Form\ProjectType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProjectRepository;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class ProjectController extends AbstractController
{
    #[Route('/', name: 'project_index')]
    public function index(request $request, ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();

        return $this->render('project/index.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'projects' => $projects
        ]);
    }


    #[Route('/project/form/', name: 'project_form')]
    public function projectFormAdd(request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('project_index');
        }
        return $this->render('project/form.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'form' => $form
        ]);
    }
    #[Route('/project/form/{id}', name: 'project_form_id')]
    public function projectFormEdit(int $id, Request $request, EntityManagerInterface $entityManager, ProjectRepository $projectRepository): Response
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            throw $this->createNotFoundException('No project found');
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/form.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'form' => $form->createView(),
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
    public function projectRemove(request $request, int $id, ProjectRepository $repository, EntityManagerInterface $entityManagerInterface): Response
    {
        $project = $repository->find($id);
        if (!$project) {
            throw $this->createNotFoundException('Car not found');
        }
        $entityManagerInterface->remove($project);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('project_index');
    }

    #[Route('/project/manager/{id}', name: 'project_id')]
    public function projectFind(request $request, int $id, TaskRepository $TaskRepository, ProjectRepository $projectRepository): Response
    {
        $tasks = $TaskRepository->findBy(['project' => $id]);
        $project = $projectRepository->find($id);
        if (!$project) {
            throw $this->createNotFoundException('Project not found');
        }

        return $this->render('project/project.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'id' => $id,
            'project' => $project,
            'tasks' => $tasks
        ]);
    }
}
