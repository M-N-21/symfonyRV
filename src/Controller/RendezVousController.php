<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\MedecinRepository;
use App\Repository\PatientRepository;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rendez/vous')]
class RendezVousController extends AbstractController
{
    #[Route('/', name: 'app_rendez_vous_index', methods: ['GET'])]
    public function index(RendezVousRepository $rendezVousRepository, PatientRepository $patientRepository): Response
    {
        $user = $this->getUser();
        $patient = $patientRepository->findOneBy(["email" => $user->getUserIdentifier()]);
        $rvs = $rendezVousRepository->findBy(["patient" => $patient]);
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rvs,
        ]);
    }

    #[Route('/medecin', name: 'app_rendez_vous_medecin_index', methods: ['GET'])]
    public function medecin(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('rendez_vous/rvmedecin.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PatientRepository $patientRepository): Response
    {
        $user = $this->getUser();
        $patient = $patientRepository->findOneBy(["email" => $user->getUserIdentifier()]);

        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezVou->setPatient($patient);
                        // dd($patient, $user);
            if ($rendezVou->getHeure()->format('H:i') > '17:00' || $rendezVou->getHeure()->format('H:i') < '08:00'){
                $this->addFlash("error","Veuillez choisir une heure entre 08h00 et 17h 00");
            }else{
                $entityManager->persist($rendezVou);
                $entityManager->flush();
                return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);

            }
            

        }

        return $this->render('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendez_vous_show', methods: ['GET'])]
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    #[Route('medecin/{id}', name: 'app_rendez_vous_valider', methods: ['GET'])]
    public function valider(RendezVous $rendezVou, MedecinRepository $medecinRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $medecin = $medecinRepository->findOneBy(["email" => $user->getUserIdentifier()]);
        $rendezVou->setMedecin($medecin);
        $entityManager->persist($rendezVou);
        $entityManager->flush();

        return $this->redirectToRoute('app_rendez_vous_medecin_index');
    }

    #[Route('/{id}/edit', name: 'app_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVou->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
}