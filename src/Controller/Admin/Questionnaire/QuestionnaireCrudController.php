<?php

declare(strict_types=1);

namespace App\Controller\Admin\Questionnaire;

use App\Entity\Questionnaire\Questionnaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class QuestionnaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Questionnaire::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            CollectionField::new('questions')->onlyOnDetail(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }
}
