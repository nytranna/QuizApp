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





if(empty($_POST['quizid'])){
    header('Location: index.php');
}


$data = [];

foreach ($_POST as $key => $value) {
    if (strpos($key, 'question_') === 0) {
        $questionNumber = str_replace('question_', '', $key);
        $data[$questionNumber] = $value;
    }
}

$quizId = $_POST['quizid'];
$userId = $_SESSION['uzivatel_id'];

//
//$qqIds = $quizQuestionRepository->selectQQIds($quizId);
//
//foreach ($qqIds as $qqId){
//    $userQuestionRepository->deleteUQ(["quiz_question_id" => $qqId, "user_id" => $userId]);
//}

$questionsOfQuiz = $questionRepository->selectQuestion($quizId);


foreach ($data as $q_id => $val) {
    //var_dump($qqid);
    $quizQuestion = $quizQuestionRepository->selectIdQQ($_POST['quizid'], $q_id);
    $quizQuestionId = '';
    if ($quizQuestion && count($quizQuestion) > 0) {
        $quizQuestionId = $quizQuestion[0]['id'];
    }

    $userQuestionRepository->insertUQ([
        'user_id' => $userId,
        'quiz_question_id' => $quizQuestionId,
        'answer' => $val
    ]);

}



?>


    <div class="col-md-4 mx-auto"">

        <h1>Výsledky kvízu</h1>

        <?php


        foreach ($questionsOfQuiz as $question) {

            $userAnswer = isset($data[$question['id']]) ? $data[$question['id']] : null;
            $isCorrect = $userAnswer === $question['right_answer'];
            $qqIdKey = 'quizquestion_id_' . $question['id'];
            $quizQuestionId = isset($_POST[$qqIdKey]) ? $_POST[$qqIdKey] : 'N/A'; // qq id

                if(in_array($question['id'], array_keys($data))) {
                    if ( $data[$question['id']] == $question['right_answer'])
                    {
                        echo '<div class="alert alert-success fw-bold mt-5" role="alert">✓ '.htmlspecialchars($question['question']).'</div>';
                    }
                    else{
                        echo '<div class="alert alert-danger fw-bold mt-5" role="alert">× '.htmlspecialchars($question['question']).'</div>';
                    }
                }
                    else{
                    echo '<div class="alert alert-danger fw-bold mt-5" role="alert">× '.htmlspecialchars($question['question']).'</div>';
                    echo '<div class="fw-bold">Nezodpovězená odpověď</div>';
                }

                echo '<div class="fw-bold">Správná odpověď: '.htmlspecialchars($question['right_answer']).'</div>';

                $abcd = ['a','b','c','d'];
                echo '<ol class="list-group mt-3">';

                foreach ($abcd as $letter){
                    $class = '';

                    if(!empty($data[$question['id']]) && $data[$question['id']] == $question['right_answer'] && $data[$question['id']] == $letter){
                        $class = ' list-group-item-success';
                    }elseif(!empty($data[$question['id']]) && $data[$question['id']] == $letter){
                        $class = ' list-group-item-danger';
                    }

                    echo '<li class="list-group-item'.$class.'">'.htmlspecialchars($letter).') '.htmlspecialchars($question['option_'.$letter]).'</li>';
                }

                echo '</ol>';
                echo '<br>';
            }
        ?>

        <a href="index.php" class="btn btn-primary mb-3">Zpět na kvízy</a>

    </div>

</body>
</html>



