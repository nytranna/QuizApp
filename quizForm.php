<?php

session_start();

include 'header.php';

include 'checkLogin.php';

require_once __DIR__.'/QuizRepository.php';
$quizRepository = new QuizRepository();

require_once __DIR__.'/CategoryRepository.php';
$categoryRepository = new CategoryRepository();

require_once __DIR__.'/QuestionRepository.php';
$questionRepository = new QuestionRepository();

require_once __DIR__.'/QuizQuestionRepository.php';
$quizQuestionRepository = new QuizQuestionRepository();

$categories = $categoryRepository->selectCategory();

$name = '';
$description = '';
$category_id = '';

$chyby = [];


if(!empty($_POST)) {


//    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category_id = trim($_POST['category_id'] ?? '');


    if (isset($name) && $name == "") {
        $chyby[] = 'Název kategorie je povinný.';
    }
    if (empty($description)) {
        $chyby[] = 'Popis kategorie je povinný.';
    }
    if (empty($category_id)) {
        $chyby[] = 'Výběr kategorie je povinný.';
    }

    foreach ($categories as $category) {
        if ($category['id'] == $category_id) {
            $categoryName = $category['name'];
            break;
        }
    }

    if (empty($chyby)) {

        $questions = $questionRepository->selectRandomQuestions($category_id);

        if (count($questions) >= 5) {

            $quizRepository->insertQuiz([
                "name" => $_POST["name"],
                "description" => $_POST['description'],
                "author_id" => $_SESSION['uzivatel_id'],
            ]);

            $idQuiz = $quizRepository->selectLastQuiz()[0]['id'];

            foreach ($questions as $question) {
                $quizQuestionRepository->insertQuizQuestion([
                    "quiz_id" => $idQuiz,
                    "question_id" => $question['id']
                ]);
            }

            header("Location: index.php");
            exit;

        } else{
            $chyby[] = 'Nedostatek otázek v dané kategorii. Nejdříve vytvořte otázky v kategorii.';
        }
    }
}

?>


<div class="container mt-5 col-md-5">
    <h1 class="mb-4">Vytvořit nový kvíz</h1>
    <?php
    if (!empty($chyby)) {
        echo '<div class="alert alert-danger">';
        foreach ($chyby as $chyba) {
            echo '<p>' . htmlspecialchars($chyba) . '</p>';
        }
        echo '</div>';
    }
    ?>
    <form method="POST">
        <div class="mb-3">
            <label for="question" class="form-label fw-bold">Název kvízu</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name) ?>" required>
        </div>
        <div class="mb-3">
            <label for="option_a" class="form-label fw-bold">Popis kvízu</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($description) ?>" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label fw-bold">Zvol kategorii otázek kvízu</label>
            <select class="form-select" id="category" name="category_id" value="<?php echo htmlspecialchars($category_id) ?>" required>
                <option value=""></option>
                <?php
                $categories = $categoryRepository->selectCategory();
                foreach ($categories as $category) {
                    echo '<option value="' . htmlspecialchars($category['id']) . '">' . htmlspecialchars($category['name']) . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Vytvořit</button>
    </form>
</div>
</body>
</html>
