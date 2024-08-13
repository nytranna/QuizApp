<?php
require_once __DIR__.'/QuestionRepository.php';
$questionRepository = new QuestionRepository();

require_once __DIR__.'/QuizRepository.php';
$quizRepository = new QuizRepository();

require_once __DIR__.'/QuizQuestionRepository.php';
$quizQuestionRepository = new QuizQuestionRepository();

require_once __DIR__.'/UserQuestionRepository.php';
$userQuestionRepository = new UserQuestionRepository();


session_start();

include 'header.php';

include 'checkLogin.php';

$id = $_GET['id'];
$questionsOfQuiz = $questionRepository->selectQuestion($id);
$quizName = $quizRepository->selectQuiz($id)[0]['name'];

if(empty($_GET['id'])){
    header('Location: index.php');
}

$quiz = $quizRepository->selectQuiz($id);

if (empty($quiz)) {
    header('Location: index.php');
}



?>


        <div class="container">
            <div class="row justify-content-md-center mt-lg-5">

                <div class="container mb-5">

                    <div class="d-grid gap-2 col-8 mx-auto">

                        <h1 class="mb-3">Kvíz - <?php echo htmlspecialchars($quizName) ?> </h1>

                        <form method="post" action="result.php">

                            <?php foreach ($questionsOfQuiz as $question): ?>

                                <h2><?php echo htmlspecialchars($question['question']); ?></h2>


                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="<?php echo 'question_' . $question['id']; ?>" id="<?php echo 'radio_a_' . $question['id']; ?>" value="a">
                                    <label class="form-check-label" for="<?php echo 'radio_a_' . $question['id']; ?>">
                                        <?php echo htmlspecialchars($question['option_a']); ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="<?php echo 'question_' . $question['id']; ?>" id="<?php echo 'radio_b_' . $question['id']; ?>" value="b">
                                    <label class="form-check-label" for="<?php echo 'radio_b_' . $question['id']; ?>">
                                        <?php echo htmlspecialchars($question['option_b']); ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="<?php echo 'question_' . $question['id']; ?>" id="<?php echo 'radio_c_' . $question['id']; ?>" value="c">
                                    <label class="form-check-label" for="<?php echo 'radio_c_' . $question['id']; ?>">
                                        <?php echo htmlspecialchars($question['option_c']); ?>
                                    </label>
                                </div>
                                <div class="form-check mb-5">
                                    <input class="form-check-input" type="radio" name="<?php echo 'question_' . $question['id']; ?>" id="<?php echo 'radio_d_' . $question['id']; ?>" value="d">
                                    <label class="form-check-label" for="<?php echo 'radio_d_' . $question['id']; ?>">
                                        <?php echo htmlspecialchars($question['option_d']); ?>
                                    </label>
                                </div>

                            <?php endforeach; ?>

                            <input type="hidden" name="quizid" value="<?php echo htmlspecialchars($id); ?>">

                            <button class="btn btn-primary" type="submit">Odeslat odpovědi</button>

                        </form>

                    </div>


                </div>

            </div>

        </div>

    </body>

</html>
