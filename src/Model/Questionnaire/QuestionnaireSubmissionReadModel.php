<?php

declare(strict_types=1);

namespace App\Model\Questionnaire;

use App\Entity\Questionnaire\QuestionnaireSubmission;

final readonly class QuestionnaireSubmissionReadModel
{
    public function __construct(
        public string $questionnaireName,
        public string $customerName,
        public string $submittedAt,
        /** @var array<int, string> */
        public array $recommendedProducts,
    ) {
    }

    public static function fromEntity(QuestionnaireSubmission $questionnaireSubmission): QuestionnaireSubmissionReadModel
    {
        return new self(
            $questionnaireSubmission->getQuestionnaire()->getTitle(),
            $questionnaireSubmission->getCustomerName(),
            $questionnaireSubmission->getSubmittedAt()->format('Y-m-d H:i:s'),
            $questionnaireSubmission->getRecommendedProducts(),
        );
    }
}
