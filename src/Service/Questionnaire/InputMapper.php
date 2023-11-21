<?php

declare(strict_types=1);

namespace App\Service\Questionnaire;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Tree\Message\Messages;
use CuyZ\Valinor\Mapper\TreeMapper;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

#[AsDecorator(decorates: TreeMapper::class)]
final readonly class InputMapper implements TreeMapper
{
    public function __construct(private TreeMapper $decoratedTreeMapper)
    {
    }

    public function map(string $signature, mixed $source): mixed
    {
        return $this->decoratedTreeMapper->map($signature, $source);
    }

    public function outputErrors(MappingError $error): JsonResponse
    {
        $messages = Messages::flattenFromNode(
            $error->node()
        );

        $errorMessages = $messages->errors();

        $output = [];

        foreach ($errorMessages as $message) {
            $nodeName = $message->node()->name();
            $output[$nodeName][] = $message->toString();
        }

        return new JsonResponse([
            'errors' => $output,
        ], Response::HTTP_BAD_REQUEST);
    }
}
