<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Command\Questionnaire\SubmitQuestionnaireCommand;
use App\Model\Questionnaire\QuestionnaireSubmission;
use App\Model\Questionnaire\QuestionnaireSubmissionReadModel;
use App\Repository\Questionnaire\Contract\QuestionnaireRepository;
use App\Repository\Questionnaire\Contract\QuestionnaireSubmissionRepository;
use App\Service\Questionnaire\InputMapper;
use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\JsonSource;
use CuyZ\Valinor\Mapper\TreeMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

final class QuestionnaireController extends AbstractController
{
    #[Route('/questionnaire', name: 'app_questionnaire', methods: ['GET'])]
    public function index(QuestionnaireRepository $questionnaireRepository): Response
    {
        $questionnaires = $questionnaireRepository->findAll();

        return new JsonResponse($questionnaires);
    }

    #[Route('questionnaire/{id}', name: 'app_questionnaire_post', methods: ['POST'])]
    public function post(
        int $id,
        Request $request,
        TreeMapper $mapper,
        MessageBusInterface $messageBus,
        QuestionnaireSubmissionRepository $questionnaireSubmissionRepository,
    ): Response {
        try {
            $data = $mapper->map(QuestionnaireSubmission::class, new JsonSource($request->getContent()));
        } catch (MappingError $error) {
            return $mapper->outputErrors($error);
        }

        $nextSubmissionId = Ulid::generate();
        $messageBus->dispatch(new SubmitQuestionnaireCommand($nextSubmissionId, $id, $data));
        $questionnaireSubmission = $questionnaireSubmissionRepository->findByInternalId(Ulid::fromString($nextSubmissionId));

        return new JsonResponse(QuestionnaireSubmissionReadModel::fromEntity($questionnaireSubmission));
    }
}
