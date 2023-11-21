<?php

declare(strict_types=1);

namespace App\Entity\Questionnaire;

use Symfony\Component\Uid\Ulid;

class QuestionnaireSubmission
{
    private ?int $id = null;

    private string $customerName;

    private \DateTimeImmutable $submittedAt;

    /** @var array<int, string> */
    private array $recommendedProducts;

    private Questionnaire $questionnaire;

    private string $internalId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function nextId(): string
    {
        return Ulid::generate();
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): static
    {
        $this->customerName = $customerName;

        return $this;
    }

    public function getSubmittedAt(): \DateTimeImmutable
    {
        return $this->submittedAt;
    }

    public function setSubmittedAt(\DateTimeImmutable $submittedAt): static
    {
        $this->submittedAt = $submittedAt;

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function getRecommendedProducts(): array
    {
        return $this->recommendedProducts;
    }

    /**
     * @param array<int, string> $recommendedProducts
     */
    public function setRecommendedProducts(array $recommendedProducts): static
    {
        $this->recommendedProducts = $recommendedProducts;

        return $this;
    }

    public function getQuestionnaire(): Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(Questionnaire $questionnaire): static
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getInternalId(): string
    {
        return $this->internalId;
    }

    public function setInternalId(string $internalId): static
    {
        $this->internalId = $internalId;

        return $this;
    }
}
