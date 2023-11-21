<?php

declare(strict_types=1);

namespace App\Entity\Questionnaire;

use Symfony\Component\Validator\Constraints as Assert;

class Answer
{
    private ?int $id = null;

    #[Assert\NotBlank]
    private string $text;

    #[Assert\Valid]
    private AnswerRule $answerRule;

    private Question $question;

    public function __toString(): string
    {
        return $this->text;
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

    public function getAnswerRule(): AnswerRule
    {
        return $this->answerRule;
    }

    public function setAnswerRule(AnswerRule $answerRule): static
    {
        $this->answerRule = $answerRule;

        return $this;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): static
    {
        $this->question = $question;

        return $this;
    }
}
