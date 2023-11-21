<?php

declare(strict_types=1);

namespace App\Command\Questionnaire;

use App\Model\Questionnaire\QuestionnaireSubmission;

final readonly class SubmitQuestionnaireCommand
{
    public function __construct(
        public string $nextId,
        public int $questionnaireId,
        public QuestionnaireSubmission $questionnaireSubmission,
    ) {
    }
}
