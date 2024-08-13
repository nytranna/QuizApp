<?php
//
//session_start();
//
//require_once __DIR__.'/QuestionRepository.php';
//$questionRepository = new QuestionRepository();
//
//
////echo '<pre>';
////
////var_dump($_POST);exit;
//
//if(isset($_POST["question"]) &&
//    isset($_POST['option_a']) &&
//    isset($_POST['option_b']) &&
//    isset($_POST['option_c']) &&
//    isset($_POST['option_d']) &&
//    isset($_POST['right_answer']) &&
//    isset($_POST['category_id'])
//) {
//
//    $questionRepository->insertQuestion([
//        "question" => $_POST["question"],
//        "option_a" => $_POST['option_a'],
//        "option_b" => $_POST['option_b'],
//        "option_c" => $_POST['option_c'],
//        "option_d" => $_POST['option_d'],
//        "right_answer" => $_POST['right_answer'],
//        "author_id" => $_SESSION['uzivatel_id'],
//        "category_id" => $_POST['category_id'],
//    ]);
//
//
//
//
//    header('Location: myQuestions.php');
//    exit;
//
//}else{
//    header('Location: index.php');
//}
