<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\Questionnaire\QuestionnaireCrudController;
use App\Entity\Questionnaire\Question;
use App\Entity\Questionnaire\Questionnaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect(
            $adminUrlGenerator->setController(QuestionnaireCrudController::class)->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Questionnaire');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Questionnaires');
        yield MenuItem::linkToCrud('Index', 'fa fa-tags', Questionnaire::class);
        yield MenuItem::section('Questions');
        yield MenuItem::linkToCrud('Index', 'fa fa-tags', Question::class);
    }
}
