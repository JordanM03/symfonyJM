<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuController extends AbstractController
{
    #[Route('/jeu/accueil', name: 'app_jeu_accueil')]
    public function accueil(): Response
    {
        return $this->render('jeu/accueil.twig');
    }
}
