<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_list')]
    public function index(request $request, UserRepository $userRepository): Response
    {
        $userList = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'user_list' => $userList
        ]);
    }
    #[Route('/user/{id}/edit', name: 'user_edit')]
    public function edit(request $request, int $id, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/user.html.twig', [
            'current_route' => $request->attributes->get('_route'),
            'form' => $form->createView(),
            'id' => $id
        ]);
    }
    #[Route('/user/{id}/remove', name: 'user_remove')]
    public function remove(request $request, int $id, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        foreach ($user->getTasks() as $task) {
            $task->setUser(null);
            $entityManager->persist($task);
        }
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('user_list');
    }
}
