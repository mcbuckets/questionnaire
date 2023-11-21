<?php

declare(strict_types=1);

namespace App\Controller\Admin\Questionnaire;

use App\Entity\Questionnaire\Answer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class AnswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Answer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('text')
                ->setRequired(true),
            AssociationField::new('answerRule')->renderAsEmbeddedForm(),
        ];
    }
}
