<?php

namespace App\Controller;

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AdministrateurLoginType;
use App\Entity\Administrateur;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdministrateurConnexionController extends AbstractController
{
    #[Route('/administrateur/connexion', name: 'app_administrateur_connexion')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(AdministrateurLoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $adminData = $form->getData();
            $adminName = $adminData->getUsername();
            $adminPassword = $adminData->getMdpAdmin(); 

            $admin = $entityManager->getRepository(Administrateur::class)->findOneBy(['username' => $adminName]);

            if ($admin && md5($adminPassword) === $admin->getMdpAdmin()){
                return $this->render('/admin');
            }
            else {
                return $this->render('/login_page');
            }
        }



        return $this->render('administrateur_connexion/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
