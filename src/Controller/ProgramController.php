<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render(

            'program/index.html.twig',

            ['programs' => $programs]

        );
    }

    #[Route('/program/new', name: 'program_new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            return $this->redirectToRoute('program_index');
        }

        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/program/{id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'program_show')]
    public function show(Program $program): Response
    {
        $seasons = $program->getSeasons();

        return $this->render('program/show.html.twig', [

            'program' => $program,
            'seasons' => $seasons,

        ]);
    }

    #[Route('/program/{program}/season/{season}', methods: ['GET'], requirements: ['programId' => '\d+',], name: 'program_season_show')]
    public function showSeason(Program $program, Season $season): Response
    {
        $episodes = $season->getEpisodes();

        return $this->render('program/season_show.html.twig', [

            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,

        ]);
    }

    #[Route('/program/{program}/season/{season}/episode/{episode}', methods: ['GET'], requirements: ['programId' => '\d+',], name: 'program_episode_show')]
    public function showEpisode(Program $program, Season $season,Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [

            'program' => $program,
            'season' => $season,
            'episode' => $episode,

        ]);
    }
}
