<?php

// src/Controller/GuessmotsController.php

namespace App\Controller;

use App\Entity\Guessmots;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrovaparolaController extends AbstractController
{
    #[Route('/trovaparola')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $words = $entityManager->getRepository(Guessmots::class)->findAll();
        
        return $this->render('trovaparola/index.html.twig', [
            'controller_name' => 'TrovaparolaController',
            'words' => $words,
        ]);
    }

    #[Route('/trovaparola/show-word/{id}', name: 'show_word')]
    public function showWord($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        
        $word = $entityManager->getRepository(Guessmots::class)->find($id);
        
        /*
        $essais = $request->getSession()->get('essais', 3);
        $essais--;
        $request->getSession()->set('essais', $essais);
        if ($essais <= 0)
        {
            $this->addFlash('info', 'Vous avez atteint le nombre maximum de tentatives. Redirection...');
        }*/


        return $this->render('trovaparola/show_word.html.twig', [
            'controller_name' => 'TrovaparolaController',
            'word' => $word,
        ]);
    }

    #[Route('/trovaparola/check-word/{id}', name: 'check-word')]
    public function checkWord($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $word = $entityManager->getRepository(Guessmots::class)->find($id);
        $userInput = $request->request->get('userInput');

        $motsRates = $request->getSession()->get('motsRates', []);
        $motsRates[] = $userInput;
        $request->getSession()->set('motsRates', $motsRates);

        // COMPTEUR ERREURS USER
        if (count($motsRates) >= 4){
            $this->addFlash('info', 'Nombre maximum d essais atteint');
            $request->getSession()->set('motsRates', []);
        }

        if ($userInput === $word->getMot()){
            $this->addFlash('success', 'Bravo! Vous avez deviné le mot correctement.');
        } else {
            $this->addFlash('error', 'Désolé, la réponse est incorrecte. Essayez à nouveau.');

            
        }
        return $this->redirectToRoute('show_word', ['id' => $id]);
    }

    
}

