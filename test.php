<?php

require_once "Sangria.php";
require_once "GuessingGame.php";

$sangria = new Sangria();
$game = new GuessingGame($sangria);
echo $game->askQuestions($game->getRandomQuestions(10)), PHP_EOL;
