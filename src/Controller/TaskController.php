<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\ProjectType;
use App\Form\TaskType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class TaskController extends AbstractController
{

    #[Route('/task/{id}/{statut}/add', name: 'project_task_add')]
    public function taskFormAdd(request $request, int $id, int $statut, ProjectRepository $projectRepository, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response
    {
        $project = $projectRepository->find($id);


        if (!$project) {
            throw $this->createNotFoundException('No project found');
        }
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, ['project' => $project, 'status' => $statut]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setProject($project);
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('project_id', ['id' => $id]);
        }

        return $this->render('task/form.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'id' => $id,
            'statut' => $statut,
            'form' => $form->createView()
        ]);
    }
    #[Route('/task/{id}/{taskId}/edit', name: 'project_task_edit')]
    public function taskFormEdit(request $request, int $id, int $taskId, ProjectRepository $projectRepository, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response
    {
        $project = $projectRepository->find($id);


        if (!$project) {
            throw $this->createNotFoundException('No project found');
        }

        $task = $taskRepository->find($taskId);
        if (!$task) {
            throw $this->createNotFoundException('No task found');
        }

        $form = $this->createForm(TaskType::class, $task, ['project' => $project, 'status' => $task->getStatus()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('project_id', ['id' => $id]);
        }

        return $this->render('task/form.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'id' => $id,
            'taskId' => $taskId,
            'statut' => $task->getStatus(),
            'form' => $form->createView()
        ]);
    }
    #[Route('/task/{id}/{taskId}/remove', name: 'project_task_remove')]
    public function taskRemove(int $id, int $taskId, TaskRepository $repository, EntityManagerInterface $entityManagerInterface): Response
    {
        $task = $repository->find($taskId);

        if (!$task || $task->getProject()->getId() != $id) {
            throw $this->createNotFoundException('Task not found or does not belong to the specified project');
        }

        $entityManagerInterface->remove($task);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('project_id', ['id' => $id]);
    }
}
