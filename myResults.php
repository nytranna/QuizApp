<?php
session_start();
 include 'header.php';
 include 'checkLogin.php';

require_once __DIR__.'/QuizRepository.php';
$quizRepository = new QuizRepository();

$allQuizzes =  $quizRepository->selectAllQuizzes();     // všechny kvízy s id kvízu

$userId = $_SESSION['uzivatel_id'];     // id aktualne prihlaseneho uzivatele

$allUsersQuizzes = $quizRepository->selectUsersQuizzes($userId);        // všechny kvízy vyplněné aktuálne prihlasenym uzivatelem




 ?>
<div class="container">

    <h1 class="mt-5 mb-5 text-center">Moje výsledky</h1>
    <form method="post">


        <div class="row">
            <?php
                if(empty($allUsersQuizzes)){
                    echo '<div class="alert alert-primary">
                            <p>Zatím jsi nevyplnil žádný kvíz.</p>
                           </div>';
                }
            ?>

            <?php foreach ($allUsersQuizzes as $quiz): ?>
                <div class="col-sm-6 mb-3 mb-sm-0 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($quiz['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($quiz['description']); ?></p>
                            <a href="myQuizResult.php?id=<?php echo htmlspecialchars($quiz['id']); ?>" class="btn btn-primary">Zobrazit můj výsledek</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </form>
</div>
