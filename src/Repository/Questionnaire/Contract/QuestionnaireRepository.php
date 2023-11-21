<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Contract;

use App\Entity\Questionnaire\Questionnaire;

interface QuestionnaireRepository
{
    public function findById(int $id): ?Questionnaire;

    public function findAll(): iterable;
}
