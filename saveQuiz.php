<?php
//
//session_start();
//
//require_once __DIR__.'/QuestionRepository.php';
//$questionRepository = new QuestionRepository();
//
//require_once __DIR__.'/QuizRepository.php';
//$quizRepository = new QuizRepository();
//
//require_once __DIR__.'/QuizQuestionRepository.php';
//$quizQuestionRepository = new QuizQuestionRepository();
//
//include 'header.php';
//
//
//if(isset($_POST['name']) &&
//    isset($_POST['description']) &&
//    isset($_POST['category_id'])
//) {
//
//    $questions = $questionRepository->selectRandomQuestions($_POST['category_id']);
//
//    if(count($questions)>=5){
//
//        $quizRepository->insertQuiz([
//            "name" => $_POST["name"],
//            "description" => $_POST['description'],
//            "author_id" => $_SESSION['uzivatel_id'],
//        ]);
//
//        $idQuiz = $quizRepository->selectLastQuiz()[0]['id'];
//
//        foreach ($questions as $question) {
//            $quizQuestionRepository->insertQuizQuestion([
//                "quiz_id" => $idQuiz,
//                "question_id" => $question['id']
//            ]);
//        }
//
//
//    header('Location: index.php');
//    exit;
//
//    }else{
//        echo '<div class="alert alert-danger col-11 mx-auto" role="alert">
//              Nedostatek otázek v dané kategorii. Nejdříve vytvořte otázky v kategorii.
//               </div>';
//
//        echo '<div class="d-grid gap-2 col-2 mx-auto">';
//        echo '<a href="questionForm.php" class="btn btn-primary">Vytvořit otázku</a>';
//        echo '<a href="index.php" class="btn btn-primary">Zpět na hlavní stránku</a>';
//        echo '</div>';
//
//    }
//
//}else{
//    header('Location: index.php');
//
//}
//
//
//
