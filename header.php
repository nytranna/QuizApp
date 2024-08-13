<?php

require_once __DIR__.'/UserRepository.php';
$userRepository = new UserRepository();

$userRole = null;


if (!empty($_SESSION['uzivatel_id'])) {
    $userRole = htmlspecialchars($userRepository->getUserRole($_SESSION['uzivatel_id'])[0]['role']);
}

?>


<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quiz App</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/all.min.css">
        <script src="js/bootstrap.bundle.min.js"></script>
        <link rel=icon href=https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/rocket.svg>



    </head>

    <body>


        <nav class="navbar navbar-expand-lg bg-primary mb-5 py-3" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand fs-3" href="index.php">QUIZ APP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item me-3">
                            <a class="nav-link active" aria-current="page" href="ranking.php">Žebříček</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link active" aria-current="page" href="questions.php">Seznam otázek</a>
                        </li>
                        <li class="nav-item me-3 mt-1">
                            <a href="questionForm.php" class="btn btn-sm btn-outline-light">Vytvořit otázku</a>
                        </li>
                        <li class="nav-item me-3 mt-1">
                            <a href="quizForm.php" class="btn btn-sm btn-outline-light">Vytvořit kvíz</a>
                        </li>
                        <?php if ($userRole === 'admin'): ?>
                            <li class="nav-item mt-1">
                                <a href="categoryForm.php" class="btn btn-sm btn-outline-light">Vytvořit kategorii</a>
                            </li>
                        <?php endif;?>

                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                if(!empty($_SESSION['uzivatel_id'])){
                                echo htmlspecialchars($_SESSION['uzivatel_username']);}
                                ?>
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" data-bs-theme="light">
                                <?php
                                if(!empty($_SESSION['uzivatel_id'])) {
                                    echo '<li><a class="dropdown-item" href="profile.php">Můj profil</a></li>';
                                    echo '<li><a class="dropdown-item" href="myQuestions.php">Moje otázky</a></li>';
                                    echo '<li><a class="dropdown-item" href="myResults.php">Moje výsledky</a></li>';
                                    echo '<li><hr class="dropdown-divider"></li>';
                                }
                                ?>

                                <?php
                                if(!empty($_SESSION['uzivatel_id'])){
                                    echo '<li><a class="btn" href="logout.php">Odhlásit se</a></li>';
                                }else{
                                    echo '<li><a class="btn" href="login.php">Přihlásit se</a></li>';
                                    echo '<li><a class="btn" href="register.php">Registovat se</a></li>';
                                }
                                ?>

                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
