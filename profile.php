<?php

session_start();

include 'header.php';

include 'checkLogin.php';

require_once __DIR__.'/UserRepository.php';
$userRepository = new UserRepository();

require_once __DIR__.'/QuizQuestionRepository.php';
$quizQuestionRepository = new QuizQuestionRepository();

$user_id = $_SESSION['uzivatel_id'];

$answer = $quizQuestionRepository->selectAnswers($user_id);

$points = count($answer);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_username'])) {
        if (isset($_POST['cancel_username'])) {
            unset($_POST['edit_username']);
        } else {
            $new_username = $_POST['new_username'];
            $userRepository->updateUser(['username' => $new_username], ['id' => $user_id]);
            $_SESSION['uzivatel_username'] = $new_username;
            unset($_POST['edit_username']);
        }
    } elseif (isset($_POST['new_email'])) {
        if (isset($_POST['cancel_email'])) {
            unset($_POST['edit_email']);
        } else {
            $new_email = $_POST['new_email'];
            $userRepository->updateUser(['email' => $new_email], ['id' => $user_id]);
            $_SESSION['uzivatel_email'] = $new_email;
            unset($_POST['edit_email']);
        }
    }
}

?>



    <div class="container align-items-center">
        <h1 class="mt-5 mb-5 text-center">Můj profil</h1>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Moje body:</h5>
                        <p class="card-text"><?php echo htmlspecialchars($points); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Uživatelské jméno:</h5>
                        <?php if (!isset($_POST['edit_username'])): ?>
                            <p class="card-text"><?php echo htmlspecialchars($_SESSION['uzivatel_username']); ?></p>
                            <form method="post">
                                <button type="submit" class="btn btn-primary" name="edit_username">Změnit</button>
                            </form>
                        <?php else: ?>
                            <form method="post">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="new_username" name="new_username" value="<?php echo htmlspecialchars($_SESSION['uzivatel_username']); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Uložit</button>
                                <button type="submit" class="btn btn-outline-secondary" name="cancel_username">Zrušit</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">E-mail:</h5>
                        <?php if (!isset($_POST['edit_email'])): ?>
                            <p class="card-text"><?php echo htmlspecialchars($_SESSION['uzivatel_email']); ?></p>
                            <form method="post">
                                <button type="submit" class="btn btn-primary" name="edit_email">Změnit</button>
                            </form>
                        <?php else: ?>
                            <form method="post">
                                <div class="mb-3">
                                    <input type="email" class="form-control" id="new_email" name="new_email" value="<?php echo htmlspecialchars($_SESSION['uzivatel_email']); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Uložit</button>
                                <button type="submit" class="btn btn-outline-secondary" name="cancel_email">Zrušit</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Heslo:</h5>
                        <p class="card-text">**********</p>
                        <a href="changePassword.php" class="btn btn-primary">Změnit heslo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>