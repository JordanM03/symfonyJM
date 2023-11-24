<?php

namespace App\Controller;
// src/Controller/ReglagesUtilisateurController.php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DeleteAccountType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;

class ReglagesUtilisateurController extends AbstractController
{
    #[Route('/reglages/utilisateur', name: 'app_reglages_utilisateur')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeleteAccountType::class);
        $error = null;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $session = $request->getSession();
            $sessionUserId = $session->get('utilisateurId');

            $userRepository = $entityManager->getRepository(Utilisateur::class);
            $user = $userRepository->find($sessionUserId);

            if ($user && $user->getUsername() === $data['username'] && md5($data['password']) === $user->getMotdepasse()) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->flush();

            } else {
                $error = 'Mauvais compte, réessayez';
            }
            
        }

        /*

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Check if the user is authenticated
            if ($this->getUser()) {
                $user = $this->getUser();

                if ($user->getUsername() === $data['username'] && md5($data['password']) === $user->getPassword()) {
                    // Delete the user account (you may want to implement your logic here)
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($user);
                    $entityManager->flush();

                    // Redirect or show a success message
                    return $this->redirectToRoute('your_success_route');
                } else {
                    $error = 'Incorrect username or password. Please try again.';
                }
            } else {
                // Redirect to the login page if the user is not authenticated
                return $this->redirectToRoute('form_connexion');
            }
        }*/

        return $this->render('reglages_utilisateur/index.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
            'controller_name' => 'ReglagesUtilisateurController',
        ]);
    }
}
