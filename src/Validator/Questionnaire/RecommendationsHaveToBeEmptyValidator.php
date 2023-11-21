<?php

declare(strict_types=1);

namespace App\Validator\Questionnaire;

use App\Entity\Questionnaire\AnswerRule;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class RecommendationsHaveToBeEmptyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof AnswerRule) {
            throw new UnexpectedValueException($value, AnswerRule::class);
        }

        if (!$constraint instanceof RecommendationsHaveToBeEmpty) {
            throw new UnexpectedTypeException($constraint, RecommendationsHaveToBeEmpty::class);
        }

        if ($value->isIsAllExcluded() && !$value->getRecommendedProducts()->isEmpty()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', 'Recommended Products')
                ->atPath('recommendedProducts')
                ->addViolation();
        }

        if ($value->isIsAllExcluded() && !$value->getExcludedProducts()->isEmpty()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', 'Excluded Products')
                ->atPath('excludedProducts')
                ->addViolation();
        }
    }
}
