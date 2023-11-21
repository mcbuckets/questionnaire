<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire;

use App\Entity\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\Contract\QuestionnaireRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class QuestionnaireDoctrineRepository implements QuestionnaireRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function findById(int $id): ?Questionnaire
    {
        $qb = $this->entityManager->getRepository(Questionnaire::class)->createQueryBuilder('q');

        $qb
            ->addSelect([
                'questions',
                'answers',
                'rules',
            ])
            ->leftJoin('q.questions', 'questions')
            ->leftJoin('questions.answers', 'answers')
            ->leftJoin('answers.answerRule', 'rules')
            ->where('q.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findAll(): array
    {
        $qb = $this->entityManager->getRepository(Questionnaire::class)->createQueryBuilder('q');

        $qb
            ->addSelect([
                'partial questions.{id, text}',
                'partial answers.{id, text}',
                'partial rule.{id, isAllExcluded}',
                'partial nextQuestion.{id}',
                'partial recommendedProducts.{id, name}',
            ])
            ->leftJoin('q.questions', 'questions')
            ->leftJoin('questions.answers', 'answers')
            ->leftJoin('answers.answerRule', 'rule')
            ->leftJoin('rule.nextQuestion', 'nextQuestion')
            ->leftJoin('rule.recommendedProducts', 'recommendedProducts')
            ->leftJoin('rule.excludedProducts', 'excludedProducts')
            ->orderBy('questions.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }
}
