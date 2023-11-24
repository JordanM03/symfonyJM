<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Notesmots;

class NotesmotsController extends AbstractController
{
    #[Route('/notesmots', name: 'app_notesmots')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $notesRepo = $entityManager->getRepository(Notesmots::class);
        $notesList = $notesRepo->findBy([], ['notes' => 'DESC']);

        return $this->render('notesmots/index.html.twig', [
            'controller_name' => 'NotesmotsController',
            'notes' => $notesList,
        ]);
    }

    #[Route('/notes_mots', name: 'notes_mots', methods: ['POST'])]
    public function noterMot(Request $request, EntityManagerInterface $entityManager): Response
    {
        $idMot = $request->request->get('wordId');
        $noteUtilisateur = $request->request->get('noteUtilisateur');

        $note = $entityManager->getRepository(Notesmots::class)->find($idMot);

        if ($note)
        {
            $note->setNotes($note->getNotes() + $noteUtilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notesmots');
    }
}
