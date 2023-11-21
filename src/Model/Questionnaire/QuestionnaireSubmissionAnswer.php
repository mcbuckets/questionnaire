<?php

declare(strict_types=1);

namespace App\Model\Questionnaire;

final readonly class QuestionnaireSubmissionAnswer
{
    public function __construct(
        public int $questionId,
        public int $answerId,
    ) {
    }
}
