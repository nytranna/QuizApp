<?php

session_start();

include 'header.php';

include 'checkLogin.php';

require_once __DIR__.'/QuestionRepository.php';
$questionRepository = new QuestionRepository();

require_once __DIR__.'/QuizQuestionRepository.php';
$quizQuestionRepository = new QuizQuestionRepository();

$uzivatel_id = $_SESSION['uzivatel_id'];

$allQQ = $quizQuestionRepository->selectAllQuizQuestion();

$isUsed = FALSE;


if (isset($_GET['question_id'])) {
    $question_id = htmlspecialchars($_GET['question_id']);


    foreach ($allQQ as $quizQuestion) {
        if (isset($quizQuestion['question_id']) && $quizQuestion['question_id'] == $question_id) {
            $isUsed = true;
            break;
        }
    }

    if ($isUsed) {
        echo '<div class="alert alert-danger col-11 mx-auto" role="alert">
              Nelze smazat otázku, je již použita v kvízu.
               </div>';

        echo '<div class="d-grid gap-2 col-2 mx-auto">';
        echo '<a href="myQuestions.php" class="btn btn-primary">Zpět na Mé otázky</a>';
        echo '</div>';
    } else {
        $questionData = $questionRepository->selectQuestionId($question_id);

        if ($questionData && $questionData[0]['author_id'] == $uzivatel_id) {
            $questionRepository->deleteQuestion($question_id);
            header('Location: myQuestions.php');
            exit;
        } else {
            echo '<div class="alert alert-danger col-11 mx-auto" role="alert">
                  Nelze smazat otázku, nejste jejím autorem.
                   </div>';

            echo '<div class="d-grid gap-2 col-2 mx-auto">';
            echo '<a href="myQuestions.php" class="btn btn-primary">Zpět na Mé otázky</a>';
            echo '</div>';
        }
    }
} else {
    header('Location: myQuestions.php');
}
