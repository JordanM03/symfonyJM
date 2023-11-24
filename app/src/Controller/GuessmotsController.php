<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Guessmots;
use Doctrine\ORM\Query\Expr\Func;

class GuessmotsController extends AbstractController
{
    #[Route('/guessmots')]

    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        //$randonmId = rand(1, 4);

        //$score = $this->getUser() ? $this->getUser()->getScore() : $this->getScore();

        
        $word = $entityManager->getRepository(Guessmots::class)->find(3);
        $request->getSession()->set('attempts', 8);

        return $this->render('guessmots/index.html.twig', [
            'controller_name' => 'GuessmotsController',
            'word' => $word,
        ]);
    }


    /* OPTIONNEL 
    #[Route('/app_jeu_accueil/{id}', name: 'app_jeu_accueil')]
    public function showWord($id, EntityManagerInterface $entityManager): Response
    {
        // Fetch the word based on the clicked button value (id)
        $word = $entityManager->getRepository(Guessmots::class)->find($id);

        return $this->render('guessmots/partie.html.twig', [
            'controller_name' => 'GuessmotsController',
            'word' => $word,
        ]);
    }*/
    


    #[Route('/guessmots/check-word', name: 'partie_utilisateur')]
    public function comparaisonMots(Request $request, EntityManagerInterface $entityManager): Response
    {
        $propositionUtilisateur = $request->request->get('propositionUtilisateur');

        //$randonmId = $request->get('randomId');

        $word = $entityManager->getRepository(Guessmots::class)->find(3);


        if ($request->request->get('likeButton'))
        {
            $word->setPoints($word->getPoints() + 1);
            $entityManager->persist($word);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez aimé le mot!');
        }


        // OPTIONNEL
        $essais = $request->getSession()->get('essais', 7);
        
        

        if ($essais <= 1 && $propositionUtilisateur !== $word->getMot()) {
            $this->addFlash('info', 'Vous avez atteint le nombre maximum de essais. Redirection vers classement_page.');
            return $this->redirectToRoute('classement_page');
        }

        


        
        // Pour checker si la proposition utilisateur correspond bien au mot à dviner
        if ($propositionUtilisateur === $word->getMot()) {

            // Afin d'ajouter les points du mot deviné
            /*
            $userScore = $user->getScore();
            $user->setScore($userScore + 5);
            $entityManager->persist($user);
            $entityManager->flush();*/

            $this->addFlash('success', 'Bravo vous avez deviné et allez gagner des points!');
        } else {
            $this->addFlash('error', 'Vous vous êtes tromper...');
        }

        //return $this->redirectToRoute('app_jeu_accueil');
        return $this->redirectToRoute('app_jeu_accueil', ['id' => $request->get('id')]); //OPTIONAL

    }
}
