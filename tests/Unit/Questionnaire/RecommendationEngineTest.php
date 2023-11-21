<?php

declare(strict_types=1);

namespace App\Tests\Unit\Questionnaire;

use App\Entity\Questionnaire\Answer;
use App\Entity\Questionnaire\AnswerRule;
use App\Entity\Questionnaire\Product;
use App\Entity\Questionnaire\Question;
use App\Entity\Questionnaire\Questionnaire;
use App\Model\Questionnaire\QuestionnaireSubmission;
use App\Model\Questionnaire\QuestionnaireSubmissionAnswer;
use App\Service\Questionnaire\RecommendationEngine;
use App\Service\Questionnaire\RecommendationEngineInterface;
use PHPUnit\Framework\TestCase;

final class RecommendationEngineTest extends TestCase
{
    private Product $product1;
    private Product $product2;
    private Product $product3;
    private Questionnaire $questionnaire;
    private RecommendationEngineInterface $engine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->questionnaire = new Questionnaire();
        $this->engine = new RecommendationEngine();

        $this->product1 = $this->createProduct('Product 1');
        $this->product2 = $this->createProduct('Product 2');
        $this->product3 = $this->createProduct('Product 3');

        $this->setupQuestionsAndAnswers();
    }

    /**
     * @dataProvider questionnaireSubmissionProvider
     */
    public function testRecommendationEngine(array $submissionData, array $expectedResults): void
    {
        $questionnaireSubmissions = new QuestionnaireSubmission($submissionData);
        $recommendedProducts = $this->engine->generate($this->questionnaire, $questionnaireSubmissions);

        $this->assertSame($recommendedProducts, $expectedResults);
    }

    public static function questionnaireSubmissionProvider(): array
    {
        return [
            [
                [
                    new QuestionnaireSubmissionAnswer(1, 1),
                    new QuestionnaireSubmissionAnswer(2, 22),
                    new QuestionnaireSubmissionAnswer(3, 3),
                ],
                ['Product 1', 'Product 2'],
            ],
            [
                [
                    new QuestionnaireSubmissionAnswer(1, 11),
                    new QuestionnaireSubmissionAnswer(2, 22),
                    new QuestionnaireSubmissionAnswer(3, 3),
                ],
                ['Product 2', 'Product 1'],
            ],
            [
                [
                    new QuestionnaireSubmissionAnswer(1, 11),
                    new QuestionnaireSubmissionAnswer(2, 22),
                    new QuestionnaireSubmissionAnswer(3, 33),
                ],
                [],
            ],
        ];
    }

    private function setupQuestionsAndAnswers(): void
    {
        $this->addQuestionWithAnswersToQuestionnaire(1, 'Question 1', [
            ['id' => 1, 'text' => 'Answer 1', 'rule' => $this->createAnswerRule([$this->product1])],
            ['id' => 11, 'text' => 'Answer 11', 'rule' => $this->createAnswerRule([$this->product2])],
        ]);

        $this->addQuestionWithAnswersToQuestionnaire(2, 'Question 2', [
            ['id' => 2, 'text' => 'Answer 2', 'rule' => $this->createAnswerRule([$this->product3], [$this->product2])],
            ['id' => 22, 'text' => 'Answer 22', 'rule' => $this->createAnswerRule([$this->product1], [$this->product2])],
        ]);

        $this->addQuestionWithAnswersToQuestionnaire(3, 'Question 3', [
            ['id' => 3, 'text' => 'Answer 3', 'rule' => $this->createAnswerRule([$this->product2])],
            ['id' => 33, 'text' => 'Answer 33', 'rule' => $this->createAnswerRule([], [], true)],
        ]);
    }

    private function addQuestionWithAnswersToQuestionnaire(int $questionId, string $questionText, array $answersData): void
    {
        $question = $this->createPartialMock(Question::class, ['getId']);
        $question->__construct();
        $question->method('getId')->willReturn($questionId);
        $question->setText($questionText);

        foreach ($answersData as $answerData) {
            $answer = $this->createPartialMock(Answer::class, ['getId']);
            $answer->method('getId')->willReturn($answerData['id']);
            $answer->setText($answerData['text']);
            $answer->setAnswerRule($answerData['rule']);
            $question->addAnswer($answer);
        }

        $this->questionnaire->addQuestion($question);
    }

    private function createAnswerRule(array $recommendedProducts, array $excludedProducts = [], bool $isAllExcluded = false): AnswerRule
    {
        $answerRule = new AnswerRule();
        foreach ($recommendedProducts as $product) {
            $answerRule->addRecommendedProduct($product);
        }
        foreach ($excludedProducts as $product) {
            $answerRule->addExcludedProduct($product);
        }

        $answerRule->setIsAllExcluded($isAllExcluded);

        return $answerRule;
    }

    private function createProduct(string $name): Product
    {
        $product = new Product();
        $product->setName($name);

        return $product;
    }
}
