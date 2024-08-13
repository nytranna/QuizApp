<?php

session_start();

include 'header.php';

include 'checkLogin.php';

require_once __DIR__.'/QuestionRepository.php';
$questionRepository = new QuestionRepository();

require_once __DIR__.'/CategoryRepository.php';
$categoryRepository = new CategoryRepository();


$categories = $categoryRepository->selectCategory();

$question = '';
$option_a = '';
$option_b = '';
$option_c = '';
$option_d = '';
$right_answer = '';
$category_id = '';

if(!empty($_POST)){

    $chyby=[];

    $question = trim($_POST['question'] ?? '');
    $option_a = trim($_POST['option_a'] ?? '');
    $option_b = trim($_POST['option_b'] ?? '');
    $option_c = trim($_POST['option_c'] ?? '');
    $option_d = trim($_POST['option_d'] ?? '');
    $right_answer = trim($_POST['right_answer'] ?? '');
    $category_id = trim($_POST['category_id'] ?? '');


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
    if (empty($category_id)) {
        $chyby[] = 'Výběr kategorie je povinný.';
    }

    foreach ($categories as $category) {
        if ($category['id'] == $category_id) {
            $categoryName = $category['name'];
            break;
        }
    }
//    }

    if(empty($chyby)) {

//        echo 'insert';
        //insert
        $questionRepository->insertQuestion([
            "question" => $question,
            "option_a" => $option_a,
            "option_b" => $option_b,
            "option_c" => $option_c,
            "option_d" => $option_d,
            "right_answer" => $right_answer,
            "author_id" => $_SESSION['uzivatel_id'],
            "category_id" => $category_id,
        ]);

        //redirect
        header("Location: index.php");
        exit;


    }
}



?>


<div class="container mt-5 col-md-5">
    <h1 class="mb-4">Vytvořit novou otázku</h1>
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
            <label for="question" class="form-label fw-bold">Otázka</label>
            <input type="text" class="form-control" id="question" name="question" value="<?php echo htmlspecialchars($question) ?>" required>
        </div>
        <div class="mb-3">
            <label for="option_a" class="form-label fw-bold">Možnost a)</label>
            <input type="text" class="form-control" id="option_a" name="option_a" value="<?php echo htmlspecialchars($option_a) ?>" required>
        </div>
        <div class="mb-3">
            <label for="option_b" class="form-label fw-bold">Možnost b)</label>
            <input type="text" class="form-control" id="option_b" name="option_b" value="<?php echo htmlspecialchars($option_b) ?>" required>
        </div>
        <div class="mb-3">
            <label for="option_c" class="form-label fw-bold">Možnost c)</label>
            <input type="text" class="form-control" id="option_c" name="option_c" value="<?php echo htmlspecialchars($option_c) ?>" required>
        </div>
        <div class="mb-3">
            <label for="option_d" class="form-label fw-bold">Možnost d)</label>
            <input type="text" class="form-control" id="option_d" name="option_d" value="<?php echo htmlspecialchars($option_d) ?>" required>
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
            <label for="category" class="form-label fw-bold">Zvol kategorii</label>
            <select class="form-select" id="category" name="category_id" required>
                <option value=""></option>
                <?php
                foreach ($categories as $category) {
                    $selected = ($category['name'] == $categoryName) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($category['id']) . '" ' . $selected . '>' . htmlspecialchars($category['name']) . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Vytvořit</button>
    </form>
</div>
</body>
</html>

