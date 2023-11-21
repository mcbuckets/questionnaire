<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire;

use App\Entity\Questionnaire\QuestionnaireSubmission;
use App\Repository\Questionnaire\Contract\QuestionnaireSubmissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Ulid;

final readonly class QuestionnaireSubmissionDoctrineRepository implements QuestionnaireSubmissionRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function findByInternalId(Ulid $id): ?QuestionnaireSubmission
    {
        return $this->entityManager->getRepository(QuestionnaireSubmission::class)
            ->createQueryBuilder('qs')
            ->where('qs.internalId = :internal_id')
            ->setParameter('internal_id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(QuestionnaireSubmission $questionnaireSubmission): void
    {
        $this->entityManager->persist($questionnaireSubmission);
        $this->entityManager->flush();
    }
}
