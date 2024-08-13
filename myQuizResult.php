<?php
session_start();
include 'header.php';
include 'checkLogin.php';

require_once __DIR__.'/QuestionRepository.php';
$questionRepository = new QuestionRepository();

require_once __DIR__.'/UserQuestionRepository.php';
$userQuestionRepository = new UserQuestionRepository();

require_once __DIR__.'/QuizQuestionRepository.php';
$quizQuestionRepository = new QuizQuestionRepository();

require_once __DIR__.'/QuizRepository.php';
$quizRepository = new QuizRepository();


$quizId = $_GET['id'];
$userId = $_SESSION['uzivatel_id'];
$quiz = $quizRepository->selectQuiz($quizId);

if (empty($quiz)) {
    header('Location: myResults.php');
    exit;
}

$quizName = $quiz[0]['name'];

if(empty($_GET['id'])){
    header('Location: myResults.php');
}

$questionsOfQuiz = $questionRepository->selectQuestion($quizId);        // všechna data pro každou otázku z question tabulky
$infoAnswers = $userQuestionRepository->selectUserAnswers($userId, $quizId);  // všechny data pro otázku (včetně správné odpovedi, odpovedi uzivatele, quiz_question_id)

if (empty($infoAnswers)) {
    header('Location: myResults.php');
    exit;
}

$userAnswers = [];
$questionIdMap = [];

foreach ($infoAnswers as $answerInfo) {
    $quizQuestionId = $answerInfo['quiz_question_id'];
    $questionId = $answerInfo['id'];
    $answer = $answerInfo['answer'];
    $userAnswers[$questionId] = $answer;
    $questionIdMap[$quizQuestionId] = $questionId;
}

//var_dump($userAnswers);exit;

?>



<div class="col-md-4 mx-auto">

    <h1>Výsledky kvízu - <?php echo htmlspecialchars($quizName); ?> </h1>

    <?php
    foreach ($questionsOfQuiz as $question) {
        $questionId = $question['id'];
        $userAnswer = isset($userAnswers[$questionId]) ? $userAnswers[$questionId] : null;
        $isCorrect = $userAnswer === $question['right_answer'];

        if ($userAnswer !== null) {
            if ($isCorrect) {
                echo '<div class="alert alert-success fw-bold mt-5" role="alert">✓ ' . htmlspecialchars($question['question']) . '</div>';
            } else {
                echo '<div class="alert alert-danger fw-bold mt-5" role="alert">× ' . htmlspecialchars($question['question']) . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger fw-bold mt-5" role="alert">× ' . htmlspecialchars($question['question']) . '</div>';
            echo '<div class="fw-bold">Nezodpovězená odpověď</div>';
        }

        echo '<div class="fw-bold">Správná odpověď: ' . htmlspecialchars($question['right_answer']) . '</div>';

        $abcd = ['a', 'b', 'c', 'd'];
        echo '<ol class="list-group mt-3">';

        foreach ($abcd as $letter) {
            $class = '';

            if ($userAnswer !== null && $userAnswer == $question['right_answer'] && $userAnswer == $letter) {
                $class = ' list-group-item-success';
            } elseif ($userAnswer !== null && $userAnswer == $letter) {
                $class = ' list-group-item-danger';
            }

            echo '<li class="list-group-item' . $class . '">' . htmlspecialchars($letter) . ') ' . htmlspecialchars($question['option_' . $letter]) . '</li>';
        }

        echo '</ol>';
        echo '<br>';
    }
    ?>

    <a href="myResults.php" class="btn btn-primary mb-3">Zpět na mé výsledky</a>

</div>

</body>
</html>