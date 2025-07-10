<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Form\FestivalFilterType;
use App\Form\FestivalType;
use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/festival')]
final class FestivalController extends AbstractController
{
    #[Route(name: 'app_festival_index', methods: ['GET'])]
    public function index(Request $request, FestivalRepository $festivalRepository): Response
    {
        $form = $this->createForm(FestivalFilterType::class);
        $form->handleRequest($request);
        $search = $form->get('search')->getData();
        if ($search) {
            $festivals = $festivalRepository->findBySearch($search);
        } else {
            $festivals = $festivalRepository->findAll();
        }

        return $this->render('festival/index.html.twig', [
            'form' => $form->createView(),
            'festivals' => $festivals,
        ]);
    }

    #[Route('/new', name: 'app_festival_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $festival = new Festival();
        $form = $this->createForm(FestivalType::class, $festival);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('assets_images_directory'),
                    $newFilename
                );
                $festival->setImage($newFilename);
            }
            $entityManager->persist($festival);
            $entityManager->flush();

            return $this->redirectToRoute('app_festival_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('festival/new.html.twig', [
            'festival' => $festival,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_festival_show', methods: ['GET'])]
    public function show(Festival $festival): Response
    {
        return $this->render('festival/show.html.twig', [
            'festival' => $festival,
        ]);
    }

    #[Route('/{id}/bands', name: 'app_festival_bands', methods: ['GET'])]
    public function showBands(Festival $festival): Response
    {
        return $this->render('festival/show_bands.html.twig', [
            'festival' => $festival,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_festival_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Festival $festival, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FestivalType::class, $festival);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('assets_images_directory'),
                    $newFilename
                );
                $festival->setImage($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_festival_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('festival/edit.html.twig', [
            'festival' => $festival,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_festival_delete', methods: ['POST'])]
    public function delete(Request $request, Festival $festival, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$festival->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($festival);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_festival_index', [], Response::HTTP_SEE_OTHER);
    }
}
