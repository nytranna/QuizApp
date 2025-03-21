<?php

session_start();

include 'header.php';

require_once __DIR__.'/QuizRepository.php';
$quizRepository = new QuizRepository();

$allQuizzes =  $quizRepository->selectAllQuizzes();

?>

        <div class="container">
            <h1>Quiz App</h1>

            <p>Vítejte v aplikaci Quiz App, kde si můžete otestovat své znalosti v různých oblastech. Vyberte si test z nabídky níže a začněte ihned!</p>

            <div class="row">

                <?php foreach ($allQuizzes as $quiz): ?>
                    <div class="col-sm-6 mb-3 mb-sm-0 mt-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($quiz['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($quiz['description']); ?></p>
                                <a href="quiz.php?id=<?php echo htmlspecialchars($quiz['id']); ?>" class="btn btn-primary">Spustit kvíz</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>


            </div>

        </div>
    </body>
</html>



