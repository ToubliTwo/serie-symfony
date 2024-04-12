<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/series', name: 'serie_')]
class SerieController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(SerieRepository $seriesRepository): Response
    {
        $series = $seriesRepository->findBestSeries();

        return $this->render('serie/list.html.twig', [
            'series' => $series
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function details(int $id, SerieRepository $seriesRepository): Response
    {
        $serie = $seriesRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException('oh no!!! this serie does not exist!');
        }

        return $this->render('serie/details.html.twig', [
            'serie' => $serie
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());

        $serieForm = $this->createForm(SerieType::class, $serie);

        $serieForm->handleRequest($request);

        if ($serieForm->isSubmitted() && $serieForm->isValid()) {

            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash('success', 'Série added! Good job.');
            return $this->redirectToRoute('serie_details', ['id' => $serie->getId()]);
        }
        //togo traiter le formulaire

        return $this->render('serie/create.html.twig', [
            'serieForm' => $serieForm->createView()
        ]);
    }

    #[Route('/demo', name: 'em-demo')]
    public function demo(EntityManagerInterface $entityManager): Response
    {
        //crée une instance de mon entité
        $serie = new Serie();
        //hydrate les propriétés
        $serie->setName('pif');
        $serie->setBackdrop('paf');
        $serie->setPoster('pouf');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime("- 1 year"));
        $serie->setLastAirDate(new \DateTime("- 6 month"));
        $serie->setGenres('comedy');
        $serie->setOverview('lorem ipsum');
        $serie->setPopularity('8.5');
        $serie->setStatus('canceled');
        $serie->setTmdbId(123456);
        $serie->setVote('8.5');

        dump($serie);

        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);

        //$entityManager->remove($serie);

        $serie->setGenres('drama');
        $entityManager->flush();

        //$entityManager = $this->getDoctrine()->getManager();

        return $this->render('serie/create.html.twig');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Serie $serie, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->redirectToRoute('main_home');
    }
}
