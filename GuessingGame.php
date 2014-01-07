<?php

require_once "Sangria.php";

class GuessingGame
{
    protected $sangria;

    protected $someVerbs = ["escuchar", "hablar", "trabajar", "cantar", "bailar", "beber", "llamarse", "leer", "comer", "vivir", "sentir", "morir", "salir", "ser", "tener", "estar"];

    public function __construct(Sangria $sangria)
    {
        $this->sangria = $sangria;
    }

    public function getRandomQuestion()
    {
        $verb = $this->someVerbs[mt_rand(0, count($this->someVerbs) - 1)];
        $pronounIndex = mt_rand(0, count($this->sangria->pronouns) - 1);
        $answer = $this->sangria->conjugate($verb, $pronounIndex);

        return compact('verb', 'pronounIndex', 'answer');
    }

    public function getRandomQuestions($count = 1)
    {
        $questions = [];
        for($i = 0; $i < $count; ++$i) {
            $questions[] = $this->getRandomQuestion();
        }
        return $questions;
    }

    public function ask(Array $question)
    {
        $stdin = fopen('php://stdin', 'r');
        printf("%s\n%s ____ ? ", ucfirst($question['verb']), $this->sangria->pronouns[$question['pronounIndex']]);
        $userAnswer = strtolower(trim(fgets($stdin)));
        fclose($stdin);
        if($userAnswer === $question['answer']) {
            printf("Bien! :)\n\n");
            return true;
        } else {
            printf("No! :(\nLa buena requesta es: %s\n\n", $question['answer']);
            return false;
        }
    }

    public function askQuestions(Array $questions)
    {
        $correctAnswers = 0;
        foreach($questions as $question) {
            if($this->ask($question)) {
                ++$correctAnswers;
            }
        }
        return $correctAnswers;
    }
}
