<?php

declare(strict_types=1);

namespace App\Validator\Questionnaire;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class RecommendationsHaveToBeEmpty extends Constraint
{
    public string $message = '{{ string }} has to be empty. Exclude all selected.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return RecommendationsHaveToBeEmptyValidator::class;
    }
}
