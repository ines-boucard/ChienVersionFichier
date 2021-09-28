<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChiensController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $finder = new Finder();
        $finder->directories()->in("../public/photos");

        return $this->render('chiens/index.html.twig', [
            "dossiers" => $finder

        ]);
    }

    #[Route('/voir/{dossier}', name: 'voirDossier')]
    public function voirDossier($dossier)
    {
        $finder = new Finder();
        $finder->files()->in("../public/photos/" . urldecode($dossier));
        return $this->render('chiens/voirDossier.html.twig', [
            "photos" => $finder,
            "dossier" => $dossier
        ]);
    }
}
