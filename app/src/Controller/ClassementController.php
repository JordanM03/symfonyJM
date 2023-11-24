<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;

class ClassementController extends AbstractController
{
    #[Route('/classement', name: 'app_classement')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        // Prende info de la session
        $session = $request->getSession();
        $userInfo = $session->get('utilisateurId');
        $user = $entityManager->getRepository(Utilisateur::class)->find($userInfo);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur no n présent dans la BDD');
        }

        $username = $user->getUsername();



        $utilisateurRepo = $entityManager->getRepository(Utilisateur::class);
        $users = $utilisateurRepo->findBy([], ['score' => 'DESC']);

        return $this->render('classement/index.html.twig', [
            'controller_name' => 'ClassementController',
            'utilisateurs' => $users,
            'utilisateurSession' => $username,
        ]);
    }
}
