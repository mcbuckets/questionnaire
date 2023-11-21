<?php

declare(strict_types=1);

namespace App\Command\Questionnaire;

use App\Entity\Questionnaire\QuestionnaireSubmission;
use App\Repository\Questionnaire\Contract\QuestionnaireRepository;
use App\Repository\Questionnaire\Contract\QuestionnaireSubmissionRepository;
use App\Service\Questionnaire\RecommendationEngineInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SubmitQuestionnaireCommandHandler
{
    public function __construct(
        private QuestionnaireRepository $questionnaireRepository,
        private QuestionnaireSubmissionRepository $questionnaireSubmissionRepository,
        private RecommendationEngineInterface $recommendationEngine,
    ) {
    }

    public function __invoke(SubmitQuestionnaireCommand $command): void
    {
        $questionnaire = $this->questionnaireRepository->findById($command->questionnaireId);

        if (null === $questionnaire) {
            throw new \RuntimeException('Questionnaire not found');
        }

        $recommendations = $this->recommendationEngine->generate($questionnaire, $command->questionnaireSubmission);

        $questionnaireSubmission = new QuestionnaireSubmission();
        $questionnaireSubmission->setInternalId($command->nextId);
        $questionnaireSubmission->setQuestionnaire($questionnaire);
        $questionnaireSubmission->setRecommendedProducts($recommendations);
        $questionnaireSubmission->setSubmittedAt(new \DateTimeImmutable());
        $questionnaireSubmission->setCustomerName('John Doe');

        $this->questionnaireSubmissionRepository->save($questionnaireSubmission);
    }
}
