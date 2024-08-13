<?php

session_start();

include 'header.php';

include 'checkLogin.php';


require_once __DIR__.'/QuestionRepository.php';
$questionRepository = new QuestionRepository();

require_once __DIR__.'/CategoryRepository.php';
$categoryRepository = new CategoryRepository();

require_once __DIR__.'/UserRepository.php';
$userRepository = new UserRepository();


$userRole = null;

if (!empty($_SESSION['uzivatel_id'])) {
    $userRole = $userRepository->getUserRole($_SESSION['uzivatel_id'])[0]['role'];
}

if ($userRole != 'admin'){
    header('Location: index.php');
}

$category_name = '';
$chyby=[];

if(!empty($_POST)){

    $category_name = trim($_POST['name'] ?? '');

    if (empty($category_name)) {
        $chyby[] = 'Název kategorie je povinný.';
    }

    if(empty($chyby)) {
        if ($userRole === 'admin') {
            $categoryRepository->insertCategory([
                "name" => $_POST['name'],
            ]);

            header("Location: index.php");
            exit;
        } elseif ($userRole != 'admin') {
//            header('Location: index.php');
            $chyby[] = 'Pro vytvoření nové kategorie musíš mít roli admin.';
        }
    }

}


?>


<div class="container mt-5 col-md-5">
    <h1 class="mb-4">Vytvořit novou kategorii</h1>
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
            <label for="name" class="form-label fw-bold">Kategorie</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category_name) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mb-3">Vytvořit</button>
    </form>
</div>
</body>
</html>

