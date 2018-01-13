<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Account;
use AppBundle\Entity\Category;
use AppBundle\Entity\RegistryEntry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseAdminController
{
    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function dashboardAction()
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $accounts = $entityManager->getRepository(Account::class)->findAll();
        $accountBalances = $entityManager->getRepository(RegistryEntry::class)->getAccountBalances();
        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render(':Dashboard:dashboard.html.twig', [
            'accounts' => $accounts,
            'accountBalances' => $accountBalances,
            'categories' => $categories,
        ]);
    }
}
