<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Festival;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookingController extends AbstractController
{
    #[Route('admin/booking', name: 'app_booking')]
    public function index(Request $request, BookingRepository $bookingRepository): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $queryBuilder = $bookingRepository->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC');

        $total = count($queryBuilder->getQuery()->getResult());

        $bookings = $queryBuilder
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $totalPages = ceil($total / $limit);

        return $this->render('admin/booking/index.html.twig', [
            'controller_name' => 'BookingController',
            'bookings' => $bookings,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/profile/{id}/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Festival $festival): Response
    {
        $bookedFestival = $festival;
        $booking = new Booking();
        $booking->setBookedFestival($bookedFestival);
        $user = $this->getUser();
        $booking->setEmail($user->getEmail());
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();

            $this->addFlash('success', 'Booking successful!');

            return $this->redirectToRoute('app_user_bookings');
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/admin/booking/reports', name: 'app_booking_reports')]
    public function reports(Request $request, BookingRepository $bookingRepository): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $reportDataFull = $bookingRepository->getBookingReportPerFestival();

        $total = count($reportDataFull);
        $totalPages = ceil($total / $limit);

        $total = count($reportDataFull);
        $totalPages = ceil($total / $limit);

        $reportData = array_slice($reportDataFull, $offset, $limit);
        return $this->render('admin/booking/reports.html.twig', [
            'reportData' => $reportData,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
