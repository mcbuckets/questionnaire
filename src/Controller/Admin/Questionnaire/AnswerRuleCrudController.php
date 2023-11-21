<?php

declare(strict_types=1);

namespace App\Controller\Admin\Questionnaire;

use App\Entity\Questionnaire\AnswerRule;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

final class AnswerRuleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AnswerRule::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setFormThemes(['admin/field/recommended.html.twig', '@EasyAdmin/crud/form_theme.html.twig']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('recommendedProducts'),
            AssociationField::new('excludedProducts'),
            BooleanField::new('isAllExcluded', 'Exclude all'),
            AssociationField::new('nextQuestion')
                ->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                    return $queryBuilder
                        ->where('entity.questionnaire = :questionnaire_id')
                        ->setParameter('questionnaire_id', $this->getContext()->getEntity()->getInstance()->getQuestionnaire()?->getId());
                }),
        ];
    }
}
