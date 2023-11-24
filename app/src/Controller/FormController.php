<?php

// src/Controller/FormController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\NameFormType;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormController extends AbstractController
{    
    #[Route('/form_page')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(NameFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $nomUser = $user->getUsername(); // On prend le userName pour checker son existence

            // On vérifie que le username n'est pas déjà présent
            $userExistant = $entityManager->getRepository(Utilisateur::class)->findOneBy(['username' => $nomUser]);
            if ($userExistant){
                $this->addFlash('error', 'Ce nom utilisateur existe déjà !');
                return $this->render('form/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $crypteMdp = md5($user->getMotdepasse());
            $user->setMotdepasse($crypteMdp);

            $user->setScore(0);

            // Insertion des données dans la BDD si username n'est pas déjà existant
            $entityManager->persist($user);
            $entityManager->flush();

            // Et redirection vers le message de données enregistrées
            return $this->redirectToRoute('form_envoye');
        }

        return $this->render('form/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/form_envoye', name:'form_envoye')]
    public function formEnvoye():Response
    {
        return $this->render('formEnvoye/form_envoye.twig');
    }


}
