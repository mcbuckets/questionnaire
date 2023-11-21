<?php

declare(strict_types=1);

namespace App\Model\Questionnaire;

final readonly class QuestionnaireSubmission
{
    public function __construct(
        /** @var QuestionnaireSubmissionAnswer[] */
        public array $answers,
    ) {
    }
}
