<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

#[Route('/task')]
class TaskController extends AbstractController
{
    #[Route('/{id}', name: 'task_index', methods: ['GET'], requirements: ['id' => '\d+'] )]
    public function index(int $id=1, TaskRepository $taskRepository, ProjectRepository $projectRepository ): Response
    {
        // récuperer le projet de l'utilisateur connecté
        $project = $projectRepository->find(['id' => $id]);
        return $this->render('task/index.html.twig', [
            // récupérer le tache associé au projet
            'tasks' => $taskRepository->findBy(['project' => $project]),
            'project' => $project,
        ]);
    }

    #[Route('/new/{id}', name: 'task_new', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function new(int $id=1, ProjectRepository $projectRepository, Request $request): Response
    {
       
        $project = $projectRepository->find(['id' => $id]);
        $task = new Task();
        // ajoute un id a cette tache
        $task->setProject($project);
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task_index', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'task_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('task_index', ['id' => $task->getProject()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'task_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Task $task): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('task_index', ['id' => $task->getProject()->getId()], Response::HTTP_SEE_OTHER);
    }
}
