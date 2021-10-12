<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChiensController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        // pour créer un formulaire, formBuilder
        $form=$this->createFormBuilder()
            // un champs texte, une classe dans symfony texte
            ->add("dossier", TextType::class, ["label"=>"Nomm du dossier"])
            // boutton subimt
            ->add("creer", SubmitType::class, ["label"=>"Créer"])
            ->getForm(); // je récupère un objet form créer
        // traitement
        $form->handleRequest($request); // je récupère les valeurs du POST
        if($form->isSubmitted() && $form->isValid()){
            // lire les données
            $data=$form->getData();
            $dossier=$data["dossier"];
            //traitement
            $fs=new Filesystem();
            $fs->mkdir("photos/$dossier");

            // aller dans le dossier
            return $this->redirectToRoute('voirDossier', ['dossier' => $dossier]);

        }





        $finder = new Finder();
        $finder->directories()->in("../public/photos");

        return $this->render('chiens/index.html.twig', [
            "dossiers" => $finder,
            "formulaire"=>$form->createView(),
        ]);

    }


    #[Route('/voir/{dossier}', name: 'voirDossier')]
    public function voirDossier($dossier, Request $request)
    {


        $form1=$this->createFormBuilder()
        ->add("photo", FileType::class, ["label"=>"photo"])
        ->add("creer", SubmitType::class, ["label"=>"envoyer"])
        ->getForm();

        $form1->handleRequest($request); // je récupère les valeurs du POST
        if($form1->isSubmitted() && $form1->isValid()) {
            // lire les données
            $data = $form1->getData();
            $data["photo"]->move("../public/photos/".$dossier
                , $data["photo"]->getClientOriginalName());
        }
        $finder = new Finder();
        $finder->files()->in("../public/photos/" . urldecode($dossier));

        return $this->render('chiens/voirDossier.html.twig', [
            "photos" => $finder,
            "dossier" => $dossier,
            "formPhoto"=>$form1->createView()

        ]);
    }
}
