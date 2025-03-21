<?php

session_start();

include 'header.php';

require_once __DIR__.'/UserRepository.php';
$userRepository = new UserRepository();


$chyby = [];

if(!empty($_POST['email'])){

    $rows = $userRepository->selectUser($_POST['email']);
    if(!empty($rows)){

        $uzivatelDb=$rows[0];

        if(password_verify($_POST['password'], $uzivatelDb['password'])){
            var_dump($_SESSION['uzivatel_id']);
            var_dump($_SESSION['uzivatel_email']);

            $_SESSION['uzivatel_id']=$uzivatelDb['id'];
            $_SESSION['uzivatel_email']=$uzivatelDb['email'];
            $_SESSION['uzivatel_username']=$uzivatelDb['username'];

            header('Location: index.php');
        }else{
            $chyby[]='E-mail a heslo se neshoduje.';
        }

    }else{
        $chyby[]='Uživatel s daným e-mailem neexistuje.';
    }

}


?>
        <div class="container">
            <div class="row justify-content-md-center mt-lg-5">
                <div class="col-md-5">


                    <h1>Přihlašování</h1>

                    <form method="post">

                        <?php
                        if (!empty($chyby)) {
                            echo '<div class="alert alert-danger">';
                            foreach ($chyby as $chyba) {
                                echo '<p>' . htmlspecialchars($chyba) . '</p>';
                            }
                            echo '</div>';
                        }
                        ?>

                        <div class="mb-0">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required/><br />
                        </div>

                        <div class="mb-0">
                            <label for="password" class="form-label">Heslo:</label>
                            <input type="password" class="form-control" name="password" id="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required/><br />
                        </div>

                        <button type="submit" class="btn btn-primary">Přihlásit se</button>
                        <a href="register.php" class="btn btn-outline-primary">Vytvořit účet</a>

                    </form>

                </div>

            </div>
        </div>
    </body>
</html>
