<?php
// src/Controller/AccountController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;

class AccountController extends AbstractController
{
    #[Route('/delete_account', name: 'delete_account', methods: ['POST'])]
    public function deleteAccount(Request $request, EntityManagerInterface $entityManager): Response
    {

        $username = $request->getSession()->get('username');

        $user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['username' => $username]);

        if ($user) {
            // Delete the user account
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a été éliminé.');
        } else {
            $this->addFlash('error', 'Username non trouvé.');
        }

        return $this->redirectToRoute('form_connexion');
    }

    #[Route('/update_account', name: 'update_account', methods: ['POST'])]
    public function updateAccount(Request $request, EntityManagerInterface $entityManager): Response
    {
        $username = $request->getSession()->get('username');
        $user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['username' => $username]);

        if (!$user){
            $this->addFlash('error', 'User not found.');
        }
        if ($request->isMethod('POST')){
            $nouveauUsername = $request->request->get('nouveauUsername');
            $nouveauMotdepasse = $request->request->get('nouveauMotdepasse');

            if ($nouveauUsername){
                $user->setUsername($nouveauUsername);
            }
            if ($nouveauMotdepasse){
                $user->setMotdepasse(md5($nouveauMotdepasse));
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez mis à jour vos données');

        }
        return $this->redirectToRoute('form_connexion');
    } 
}
