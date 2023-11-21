<?php

declare(strict_types=1);

namespace App\Entity\Questionnaire;

use App\Validator\Questionnaire as AssertQuestionnaire;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[AssertQuestionnaire\RecommendationsHaveToBeEmpty]
class AnswerRule
{
    private ?int $id = null;

    private Answer $answer;

    private ?Question $nextQuestion = null;

    /** @var Collection<int, Product> */
    private Collection $recommendedProducts;

    /** @var Collection<int, Product> */
    private Collection $excludedProducts;

    private bool $isAllExcluded;

    public function __construct()
    {
        $this->recommendedProducts = new ArrayCollection();
        $this->excludedProducts = new ArrayCollection();
        $this->isAllExcluded = false;
    }

    public function __toString(): string
    {
        return 'Rule';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getRecommendedProducts(): Collection
    {
        return $this->recommendedProducts;
    }

    public function addRecommendedProduct(Product $recommendedProduct): static
    {
        if (!$this->recommendedProducts->contains($recommendedProduct)) {
            $this->recommendedProducts->add($recommendedProduct);
        }

        return $this;
    }

    public function removeRecommendedProduct(Product $recommendedProduct): static
    {
        $this->recommendedProducts->removeElement($recommendedProduct);

        return $this;
    }

    public function getNextQuestion(): ?Question
    {
        return $this->nextQuestion;
    }

    public function setNextQuestion(?Question $nextQuestion): static
    {
        $this->nextQuestion = $nextQuestion;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getExcludedProducts(): Collection
    {
        return $this->excludedProducts;
    }

    public function addExcludedProduct(Product $excludedProduct): static
    {
        if (!$this->excludedProducts->contains($excludedProduct)) {
            $this->excludedProducts->add($excludedProduct);
        }

        return $this;
    }

    public function removeExcludedProduct(Product $excludedProduct): static
    {
        $this->excludedProducts->removeElement($excludedProduct);

        return $this;
    }

    public function isIsAllExcluded(): bool
    {
        return $this->isAllExcluded;
    }

    public function setIsAllExcluded(bool $isAllExcluded): static
    {
        $this->isAllExcluded = $isAllExcluded;

        return $this;
    }
}
