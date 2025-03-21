<?php

session_start();

include 'header.php';

include 'checkLogin.php';

require_once __DIR__.'/QuestionRepository.php';
$questionRepository = new QuestionRepository();

require_once __DIR__.'/QuizQuestionRepository.php';
$quizQuestionRepository = new QuizQuestionRepository();

require_once __DIR__.'/CategoryRepository.php';
$categoryRepository = new CategoryRepository();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit']) && isset($_POST['question_id'])) {
    header('Location: editQuestionForm.php?question_id=' . htmlspecialchars($_POST['question_id']));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['question_id'])) {
    header('Location: deleteQuestion.php?question_id=' . htmlspecialchars($_POST['question_id']));
    exit();
}


$questions = $questionRepository->selectAllQuestions();
$myQuestions = [];

$allQQ = $quizQuestionRepository->selectAllQuizQuestion();
$isUsed = FALSE;


if(!empty($_SESSION['uzivatel_id'])){

    foreach ($questions as $question) {
        if ($question['author_id'] == $_SESSION['uzivatel_id']) {
            $myQuestions[] = $question;
        }
    }
}



$category = $categoryRepository->selectCategory();


?>


<div class="container">

    <h1>Moje otázky</h1>

    <div class="row">
            <?php if (!empty($myQuestions)): ?>
                <?php foreach ($myQuestions as $q): ?>
                    <div class="col-sm-6 mb-3 mb-sm-0 mt-1">
                        <div class="card mt-4 mb-3">

                            <?php
                            $isUsed = false;
                            $question_id = $q['id'];

                            foreach ($allQQ as $quizQuestion) {
                                if (isset($quizQuestion['question_id']) && $quizQuestion['question_id'] == $question_id) {
                                    $isUsed = true;
                                    break;
                                }
                            }

                            $categoryName = null;
                            $categoryId = $q['category_id'];
                            foreach ($category as $c) {
                                if ($c['id'] == $categoryId) {
                                    $categoryName = htmlspecialchars($c['name']);
                                    break;
                                }
                            }
                            ?>

                            <div class="card-header fw-bold text-white" style="background-color: #0d6dfb;">
                                <?php echo htmlspecialchars($categoryName); ?>
                            </div>

                            <div class="card-body">



                                <h5 class="card-title"><?php echo htmlspecialchars($q['question']); ?></h5>

                                <p class="card-text">a) <?php echo htmlspecialchars($q['option_a']); ?></p>
                                <p class="card-text">b) <?php echo htmlspecialchars($q['option_b']); ?></p>
                                <p class="card-text">c) <?php echo htmlspecialchars($q['option_c']); ?></p>
                                <p class="card-text">d) <?php echo htmlspecialchars($q['option_d']); ?></p>
                                <p class="card-text">správná odpověď: <?php echo htmlspecialchars($q['right_answer']); ?>)</p>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($q['id']); ?>">
                                    <button type="submit" name="edit" class="btn btn-primary">Upravit otázku</button>
                                </form>

                                <?php if ($isUsed == false): ?>
                                    <form action="" method="post" style="display:inline;">
                                        <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($q['id']); ?>">
                                        <button type="submit" name="delete" class="btn btn-outline-danger">Smazat otázku</button>
                                    </form>
                                <?php endif; ?>


                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-primary">
                        <p>Zatím jsi nevytvořil žádnou otázku.</p>
                    </div>
            <?php endif; ?>
    </div>


</div>
</div>
</body>
</html>




