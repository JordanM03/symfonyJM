<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\LoginFormType;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    #[Route('/login_page')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            // Récupération des données de login
            $userData = $form->getData();
            $username = $userData['username'];
            $password = $userData['motdepasse'];


            // Récupération des données présentes dans la base de données en se basant sur le username
            $user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['username' => $username]);


            if ($user && md5($password) === $user->getMotdepasse()){   // Si user présent et mot de passe correspondant alors connecté sinon non
            
                // Session utilisateur
                $session = $request->getSession();
                $session->set('utilisateurId', $user->getId());
                $session->set('score', $user->getScore());
                $session->set('username', $user->getUsername()); // OPTIONNEL
                $session->set('motdepasse', $user->getMotdepasse());
                
                $this->addFlash('success', 'Bien connecté');
                //return $this->render('connreussie/connecte.html.twig');

                $score = $user->getScore();
                $username = $user->getUsername();

                return $this->render('jeu/accueil.twig', [
                    'score' => $score,
                    'username' => $username,
                ]);
            } else {
                $this->addFlash('error', 'Username ou mot de passe contenant une erreur');
                //return $this->render('login/index.html.twig');
            }
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}