<?php

declare(strict_types=1);

namespace App\Service\Questionnaire;

use App\Entity\Questionnaire\Questionnaire;
use App\Model\Questionnaire\QuestionnaireSubmission;

interface RecommendationEngineInterface
{
    /**
     * @return array<int, string>
     */
    public function generate(Questionnaire $questionnaire, QuestionnaireSubmission $questionnaireSubmission): array;
}
