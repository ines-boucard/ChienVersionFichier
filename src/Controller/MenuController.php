<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{

    public function menu(): Response
    {
        $finder = new Finder();
        $finder->directories()->in("../public/photos");
        return $this->render('menu/_menu.html.twig', [
            "dossiers" => $finder

        ]);
    }
}
