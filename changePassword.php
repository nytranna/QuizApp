<?php
session_start();

// Include necessary files
include 'header.php';
include 'checkLogin.php';

require_once __DIR__.'/UserRepository.php';
$userRepository = new UserRepository();

//var_dump($_SESSION);exit; //array(3) { ["uzivatel_id"]=> string(2) "31" ["uzivatel_email"]=> string(13) "user@email.cz" ["uzivatel_username"]=> string(4) "User" }

$userInfo = $userRepository->selectUser($_SESSION['uzivatel_email'])[0];
//var_dump($userInfo);exit; //array(7) { ["id"]=> string(2) "31" ["username"]=> string(4) "User" ["email"]=> string(13) "user@email.cz"
// ["password"]=> string(60) "$2y$10$cd21UFvKQXYyPBTKHmPsHe2.Fx8fSPrveXcayNGgHBBBvnlabe4ce" ["role"]=> NULL
// ["created_at"]=> string(19) "2024-06-09 12:28:08" ["updated_at"]=> string(19) "2024-06-09 12:29:32" }



$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
        $errors[] = 'Vyplňte všechny pole';
    } else {
//    $user = $userRepository->selectUser($_SESSION['uzivatel_email']);
        if (!password_verify($_POST['current_password'], $userInfo['password'])) {
            $errors[] = 'Aktuální heslo je špatně.';
        }
        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            $errors[] = 'Nové heslo a potvrzení hesla se neshoduje.';
        } elseif (strlen($_POST['new_password']) < 5) {
            $errors[] = 'Nové heslo musí mít alespoň 5 znaků.';
        }
    }

    if (empty($errors)) {
        $userRepository->updateUser(["password" => password_hash($_POST['new_password'], PASSWORD_DEFAULT)], ['id' => $_SESSION['uzivatel_id']] );
        header('Location: profile.php');
        exit;
    }
}

?>


<div class="container col-5">
    <h2 class="mt-5 text-center">Změna hesla</h2>
    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger">
            <div>
                <?php foreach ($errors as $error) { ?>
                    <div><?php echo $error; ?></div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <form method="post">
        <div class="form-group">
            <label class="fw-bold mb-1" for="current_password">Aktuální heslo:</label>
            <input type="password" class="form-control mb-3" id="current_password" name="current_password" required>
        </div>
        <div class="form-group">
            <label class="fw-bold mb-1" for="new_password">Nové heslo:</label>
            <input type="password" class="form-control mb-3" id="new_password" name="new_password" required>
        </div>
        <div class="form-group">
            <label class="fw-bold mb-1" for="confirm_password">Potvrďte nové heslo:</label>
            <input type="password" class="form-control mb-3" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Změnit heslo</button>
        <a href="profile.php" class="btn btn-outline-secondary">Zrušit</a>
    </form>
</div>
</body>
</html>
