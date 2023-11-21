<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Contract;

use App\Entity\Questionnaire\QuestionnaireSubmission;
use Symfony\Component\Uid\Ulid;

interface QuestionnaireSubmissionRepository
{
    public function findByInternalId(Ulid $id): ?QuestionnaireSubmission;

    public function save(QuestionnaireSubmission $questionnaireSubmission): void;
}
