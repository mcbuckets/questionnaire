<?php

declare(strict_types=1);

namespace App\Service\Questionnaire;

use App\Entity\Questionnaire\Answer;
use App\Entity\Questionnaire\Question;
use App\Entity\Questionnaire\Questionnaire;
use App\Model\Questionnaire\QuestionnaireSubmission;

final readonly class RecommendationEngine implements RecommendationEngineInterface
{
    public function generate(Questionnaire $questionnaire, QuestionnaireSubmission $questionnaireSubmission): array
    {
        $answers = [];
        /** @var Question $question */
        foreach ($questionnaire->getQuestions() as $question) {
            foreach ($questionnaireSubmission->answers as $submittedAnswer) {
                if ($submittedAnswer->questionId === $question->getId()) {
                    $foundAnswer = $question->getAnswers()->filter(
                        fn (Answer $answer) => $submittedAnswer->answerId === $answer->getId()
                    )->first();

                    if ($foundAnswer instanceof Answer) {
                        $answers[] = $foundAnswer;
                    }
                }
            }
        }

        $recommendedProducts = [];
        foreach ($answers as $answer) {
            $answerRule = $answer->getAnswerRule();
            if ($answerRule->isIsAllExcluded()) {
                $recommendedProducts = [];
                continue;
            }

            foreach ($answerRule->getRecommendedProducts() as $recommendedProduct) {
                if (
                    false === in_array($recommendedProduct, $answerRule->getExcludedProducts()->toArray())
                    && false === in_array($recommendedProduct, $recommendedProducts)
                ) {
                    $recommendedProducts[] = $recommendedProduct->getName();
                }
            }
        }

        return $recommendedProducts;
    }
}
