<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Questionnaire\Answer;
use App\Entity\Questionnaire\AnswerRule;
use App\Entity\Questionnaire\Question;
use App\Entity\Questionnaire\Questionnaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class QuestionnaireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setTitle('Erectile dysfunction');

        $manager->persist($questionnaire);

        for ($i = 0; $i < 5; ++$i) {
            $question = new Question();
            $question->setText('Question '.$i);
            $question->setQuestionnaire($questionnaire);

            for ($j = 0; $j < 2; ++$j) {
                $answer = new Answer();
                $answer->setText(['Yes', 'No'][$j]);
                $question->addAnswer($answer);

                $rule = new AnswerRule();
                $rule->addRecommendedProduct(
                    $this->getReference(ProductFixtures::PRODUCT_REFERENCE.'_'.rand(0, 3))
                );

                $answer->setAnswerRule($rule);

                $manager->persist($answer);
                $manager->persist($question);
            }
        }

        $manager->flush();
    }
}
