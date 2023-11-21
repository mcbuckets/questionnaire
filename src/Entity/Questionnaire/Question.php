<?php

declare(strict_types=1);

namespace App\Entity\Questionnaire;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class Question
{
    private ?int $id = null;

    #[Assert\NotBlank]
    private string $text;

    #[Assert\Valid, Assert\Count(min: 2, minMessage: 'question.answers.min')]
    private Collection $answers;

    private ?Questionnaire $questionnaire = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getText();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): static
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): static
    {
        $this->answers->removeElement($answer);

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): static
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }
}
