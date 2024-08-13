<?php
//
//session_start();
//
//require_once __DIR__.'/CategoryRepository.php';
//$categoryRepository = new CategoryRepository();
//
//require_once __DIR__.'/UserRepository.php';
//$userRepository = new UserRepository();
//
//include 'header.php';
//include 'checkLogin.php';
//
//
//$userRole = null;
//
//if (!empty($_SESSION['uzivatel_id'])) {
//    $userRole = $userRepository->getUserRole($_SESSION['uzivatel_id'])[0]['role'];
//}
//
//if(isset($_POST["name"])){
//
//    if ($userRole === 'admin') {
//
//        $categoryRepository->insertCategory([
//            "name" => $_POST['name'],
//        ]);
//
//        header('Location: index.php');
//        exit;
//    }elseif ($userRole != 'admin'){
//        echo '<div class="alert alert-danger col-11 mx-auto" role="alert">
//              Pro vytvoření nové kategorie musíš mít roli admin.
//               </div>';
//
//        echo '<div class="d-grid gap-2 col-2 mx-auto">';
//        echo '<a href="index.php" class="btn btn-primary">Zpět na hlavní stránku</a>';
//        echo '</div>';
//    }
//
//}else{
//    header('Location: index.php');
//}
