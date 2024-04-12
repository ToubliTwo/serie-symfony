<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeasonController extends AbstractController
{
    #[Route('/season/create', name: 'season_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $season = new Season();
        $seasonform = $this->createForm(SeasonFormType::class, $season);

        $seasonform->handleRequest($request);

        if ($seasonform->isSubmitted() && $seasonform->isValid()) {
            $entityManager->persist($season);
            $entityManager->flush();

            $this->addFlash('success', 'Season added! Good job.');
            return $this->redirectToRoute('serie_list');
        }
        return $this->render('season/create.html.twig', [
            'seasonForm' => $seasonform->createView()
        ]);
    }
}
