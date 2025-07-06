<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Repository\FestivalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FestivalRepository $festivalRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'festivals' => $festivalRepository->findAll(),
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
