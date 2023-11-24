<?php

// src/Controller/LikeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Likes;

class LikeController extends AbstractController
{
    #[Route('/like', name: 'like')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $likesRepo = $entityManager->getRepository(Likes::class);
        $likesList = $likesRepo->findBy([], ['nblikes' => 'DESC']);

        return $this->render('like/index.html.twig', [
            'controller_name' => 'LikeController',
            'likes' => $likesList,
        ]);
    }

    #[Route('/like_mot', name: 'like_mot', methods: ['POST'])]
    public function likeWord(Request $request, EntityManagerInterface $entityManager): Response
    {
        $idMot = $request->request->get('wordId');

        $like = $entityManager->getRepository(Likes::class)->find($idMot);

        if ($like) 
        {
            $like->setNblikes($like->getNblikes() + 1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('like');
    }

    #[Route('/dislike_mot', name: 'dislike_mot', methods: ['POST'])]
    public function dislikeWord(Request $request, EntityManagerInterface $entityManager): Response
    {
        $idMot = $request->request->get('wordId');

        $like = $entityManager->getRepository(likes::class)->find($idMot);

        if ($like)
        {
            $like->setNblikes($like->getNblikes() - 1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('like');
    }
}
