<?php

namespace App\Controller;

use App\Entity\TypeRV;
use App\Form\TypeRVType;
use App\Repository\TypeRVRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/r/v')]
class TypeRVController extends AbstractController
{
    #[Route('/', name: 'app_type_r_v_index', methods: ['GET'])]
    public function index(TypeRVRepository $typeRVRepository): Response
    {
        return $this->render('type_rv/index.html.twig', [
            'type_r_vs' => $typeRVRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_r_v_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeRV = new TypeRV();
        $form = $this->createForm(TypeRVType::class, $typeRV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeRV);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_r_v_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_rv/new.html.twig', [
            'type_r_v' => $typeRV,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_r_v_show', methods: ['GET'])]
    public function show(TypeRV $typeRV): Response
    {
        return $this->render('type_rv/show.html.twig', [
            'type_r_v' => $typeRV,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_r_v_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeRV $typeRV, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeRVType::class, $typeRV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_r_v_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_rv/edit.html.twig', [
            'type_r_v' => $typeRV,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_r_v_delete', methods: ['POST'])]
    public function delete(Request $request, TypeRV $typeRV, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeRV->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeRV);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_r_v_index', [], Response::HTTP_SEE_OTHER);
    }
}
