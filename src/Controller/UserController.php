<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_USER')]
final class UserController extends AbstractController
{
    #[Route('/profile/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/profile/user/bookings', name: 'app_user_bookings')]
    public function bookings(BookingRepository $bookingRepository): Response
    {
        $user = $this->getUser();
        $email = $user->getEmail();

        $bookings = $bookingRepository->findBy(['email' => $email]);

        return $this->render('user/bookings.html.twig', [
            'bookings' => $bookings,
        ]);
    }


}
