<?php

session_start();

include 'header.php';

require_once __DIR__.'/QuizRepository.php';
$quizRepository = new QuizRepository();

//$selectUser = $databaseModel->query('SELECT * FROM user WHERE username=?', ["peta"]);
//$userRepository->insertUser(["username" => "anicka", "email" => "anicka@an.en", "role" => "admin", "password" => "password"]);
//$userRepository->updateUser(['email' => 'anicka@vse.cz'], ['username' => 'anicka']);
//$userRepository->deleteUser(['username' => 'anicka']);

//$databaseModel->insert("user", [
//    "username" => "anna",
//    "email" => "anna@vse.cz",
//    "role" => "admin",
//    "password" => "password"
//]);
//
//
//$databaseModel->update("user",[
//    "email" => "anicka@vse.cz",
//], [
//    "username" => "anna"
//] );
//
//
//$databaseModel->delete("user", [
//    "username" => "anna"
//]);

//$question = $quizRepository->selectQuestion(1); - vrací otázku a odpovedi podle quiz_question_id

//$quiz = $quizRepository->selectQuiz(1);

$allQuizzes =  $quizRepository->selectAllQuizzes();

//$allIDs = [];
//
//foreach ($allQuizzes as $quiz){
//    $allIDs[] = $quiz['id'];
//}



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



