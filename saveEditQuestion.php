<?php
//
//session_start();
//
//include 'header.php';
//include 'checkLogin.php';
//
//
//require_once __DIR__.'/QuestionRepository.php';
//$questionRepository = new QuestionRepository();
//
//
//if(!empty($_SESSION['uzivatel_id'])) {
//    if (isset($_GET['question_id'])) {
//        $id = $_GET['question_id'];
//        $questionData = $questionRepository->selectQuestionId($id);
//
//
//        if ($questionData && $questionData[0]['author_id'] == $_SESSION['uzivatel_id']) {
//
//            if (isset($_POST["question"]) &&
//                isset($_POST['option_a']) &&
//                isset($_POST['option_b']) &&
//                isset($_POST['option_c']) &&
//                isset($_POST['option_d']) &&
//                isset($_POST['right_answer'])
//            ) {
//
//                $questionRepository->updateQuestion([
//                    "question" => $_POST["question"],
//                    "option_a" => $_POST['option_a'],
//                    "option_b" => $_POST['option_b'],
//                    "option_c" => $_POST['option_c'],
//                    "option_d" => $_POST['option_d'],
//                    "right_answer" => $_POST['right_answer'],
//                ], ['id' => $id]);
//
//                echo 'ok';
//
//                header('Location: myQuestions.php');
//                exit;
//
//            } else {
//                echo 'Nelze updatovat data do databáze.';
//            }
//
//        } else {
//            echo '<div class="alert alert-danger col-11 mx-auto" role="alert">
//                      Nelze upravit otázku, nejste jejím autorem.
//                       </div>';
//
//            echo '<div class="d-grid gap-2 col-2 mx-auto">';
//            echo '<a href="myQuestions.php" class="btn btn-primary">Zpět na Mé otázky</a>';
//            echo '</div>';
//        }
//
//
//    } else {
//        header('Location: index.php');
//    }
//}
