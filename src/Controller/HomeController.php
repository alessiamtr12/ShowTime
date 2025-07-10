<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Form\FestivalFilterType;
use App\Repository\FestivalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
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

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'festivals' => $festivals,
        ]);
    }

    #[Route('/{id}/bands', name: 'app_home_festival_bands', methods: ['GET'])]
    public function showBands(Festival $festival): Response
    {
        return $this->render('home/show_bands.html.twig', [
            'festival' => $festival,
        ]);
    }
}
