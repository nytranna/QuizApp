<?php

session_start();

include 'header.php';

include 'checkLogin.php';

require_once __DIR__.'/QuestionRepository.php';
$questionRepository = new QuestionRepository();

require_once __DIR__.'/CategoryRepository.php';
$categoryRepository = new CategoryRepository();


$questions = $questionRepository->selectAllQuestions();
$categories = $categoryRepository->selectCategory();

$ids = [];

foreach ($questions as $question) {
    $ids[] = $question['id'];
}

$question = '';
$option_a = '';
$option_b = '';
$option_c = '';
$option_d = '';
$right_answer = '';
$category_id = '';


if (isset($_GET['question_id'])) {
    $id = htmlspecialchars($_GET['question_id']);

    if (in_array($id, $ids)) {

        $questionData = $questionRepository->selectQuestionId($id);

        $question = htmlspecialchars($questionData[0]['question']);
        $option_a = htmlspecialchars($questionData[0]['option_a']);
        $option_b = htmlspecialchars($questionData[0]['option_b']);
        $option_c = htmlspecialchars($questionData[0]['option_c']);
        $option_d = htmlspecialchars($questionData[0]['option_d']);
        $right_answer = htmlspecialchars($questionData[0]['right_answer']);
        $categoryId = $questionData[0]['category_id'];

        $category = $categoryRepository->selectCategory();

        $categoryName = null;

        foreach ($category as $c) {
            if ($c['id'] == $categoryId) {
                $categoryName = htmlspecialchars($c['name']);
            }
        }
    }else{
        echo '<div class="alert alert-danger col-11 mx-auto" role="alert">
              Otázka, kterou chcete upravit, neexistuje.
               </div>';

        echo '<div class="d-grid gap-2 col-2 mx-auto">';
        echo '<a href="index.php" class="btn btn-primary">Zpět na hlavní stránku</a>';
        echo '</div>';exit;
    }
}else{
    header('Location: myQuestions.php');
    exit;
}


$chyby = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = trim($_POST['question'] ?? '');
    $option_a = trim($_POST['option_a'] ?? '');
    $option_b = trim($_POST['option_b'] ?? '');
    $option_c = trim($_POST['option_c'] ?? '');
    $option_d = trim($_POST['option_d'] ?? '');
    $right_answer = trim($_POST['right_answer'] ?? '');

    if (isset($question) && $question=="") {
        $chyby[] = 'Otázka je povinná.';
    }
    if (isset($option_a) && $option_a=="") {
        $chyby[] = 'Možnost a) je povinná.';
    }
    if (isset($option_b) && $option_b=="") {
        $chyby[] = 'Možnost b) je povinná.';
    }
    if (isset($option_c) && $option_c=="") {
        $chyby[] = 'Možnost c) je povinná.';
    }
    if (isset($option_d) && $option_d=="") {
        $chyby[] = 'Možnost d) je povinná.';
    }
    if (isset($right_answer) && $right_answer=="") {
        $chyby[] = 'Výběr správné odpovědi je povinný.';
    } elseif (!in_array($right_answer, ['a', 'b', 'c', 'd'])) {
        $chyby[] = 'Neplatná správná odpověď.';
    }


    if (empty($chyby)) {
        $questionRepository->updateQuestion([
            "question" => $question,
            "option_a" => $option_a,
            "option_b" => $option_b,
            "option_c" => $option_c,
            "option_d" => $option_d,
            "right_answer" => $right_answer
        ], ['id' => $id]);

        header("Location: myQuestions.php");
        exit;
    }
}
?>




<div class="container mt-5 col-md-5">
    <h1 class="mb-4">Upravit otázku</h1>
    <?php
    if (!empty($chyby)) {
        echo '<div class="alert alert-danger">';
        foreach ($chyby as $chyba) {
            echo '<p>' . htmlspecialchars($chyba) . '</p>';
        }
        echo '</div>';
    }
    ?>
    <form action="editQuestionForm.php?question_id=<?php echo $id; ?>" method="POST">
        <div class="mb-3">
            <label for="question" class="form-label fw-bold">Otázka</label>
            <input type="text" class="form-control" id="question" name="question" value="<?php echo $question ?>" required>
        </div>
        <div class="mb-3">
            <label for="option_a" class="form-label fw-bold">Možnost a)</label>
            <input type="text" class="form-control" id="option_a" name="option_a" value="<?php echo $option_a ?>" required>
        </div>
        <div class="mb-3">
            <label for="option_b" class="form-label fw-bold">Možnost b)</label>
            <input type="text" class="form-control" id="option_b" name="option_b" value="<?php echo $option_b ?>" required>
        </div>
        <div class="mb-3">
            <label for="option_c" class="form-label fw-bold">Možnost c)</label>
            <input type="text" class="form-control" id="option_c" name="option_c" value="<?php echo $option_c ?>" required>
        </div>
        <div class="mb-3">
            <label for="option_d" class="form-label fw-bold">Možnost d)</label>
            <input type="text" class="form-control" id="option_d" name="option_d" value="<?php echo $option_d ?>" required>
        </div>
        <div class="mb-3">
            <label for="right_answer" class="form-label fw-bold">Vyber správnou odpověď</label>
            <select class="form-select" id="right_answer" name="right_answer" required>
                <option value=""></option>
                <option value="a" <?php echo $right_answer === 'a' ? 'selected' : '' ?>>a)</option>
                <option value="b" <?php echo $right_answer === 'b' ? 'selected' : '' ?>>b)</option>
                <option value="c" <?php echo $right_answer === 'c' ? 'selected' : '' ?>>c)</option>
                <option value="d" <?php echo $right_answer === 'd' ? 'selected' : '' ?>>d)</option>
            </select>
        </div>
        <div class="mb-3">
            <fieldset disabled>
                <div class="mb-3">
                    <label for="disabledTextInput" class="form-label fw-bold">Kategorie</label>
                    <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php echo $categoryName?>">
                </div>
            </fieldset>
        </div>

        <input type="hidden" name="question_id" value="<?php echo $id; ?>">

        <button type="submit" class="btn btn-primary mb-3">Uložit</button>
    </form>
</div>
</body>
</html>

