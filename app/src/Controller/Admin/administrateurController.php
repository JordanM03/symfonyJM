<?php

namespace App\Controller\Admin;

use App\Entity\Guessmots;
use App\Entity\Utilisateur;
use App\Entity\Likes;
use App\Entity\Notesmots;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class administrateurController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(GuessmotsCrudController::class)->generateUrl();

        return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Www');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', '#');
        yield MenuItem::linktoCrud('Guessmots', 'fas fa-map-marker-alt', Guessmots::class);
        yield MenuItem::linktoCrud('Utilisateur', 'fa fa-user-o', Utilisateur::class);
        yield MenuItem::linktoCrud('Likes', 'fa fa-heart-o', Likes::class);
        yield MenuItem::linktoCrud('Notesmots', 'fa fa-heart-o', Notesmots::class);
    }
}
