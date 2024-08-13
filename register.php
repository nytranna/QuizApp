<?php

session_start();

include 'header.php';

require_once __DIR__.'/UserRepository.php';
$userRepository = new UserRepository();


if(!empty($_POST['email'])){

    $rows = $userRepository->selectUser($_POST['email']);

    $chyby=[];
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $chyby[]='Musíte zadat platný email.';
    }else{

        if(!empty($rows)){
            $chyby[]='Uživatel s daným e-mailem je již registrován.';
        }
    }

    if(empty($_POST['heslo']) || (mb_strlen($_POST['heslo'], 'utf8')<5)){
        $chyby[]='Musíte zadat alespoň 5 znaků.';
    }elseif(empty($_POST['heslo2']) || ($_POST['heslo']!=$_POST['heslo2'])){
        $chyby[]='Zadaná hesla se neshodují.';
    }

    if(empty($chyby)) {

        $userRepository->insertUser(["username" => $_POST["username"] , "email" => $_POST['email'], "password" => password_hash($_POST['heslo'],PASSWORD_DEFAULT)]);
        echo "insert";

        $userRepository->selectUser($_POST['email']);

        header('Location: login.php');
    }
}



?>


        <div class="container">
            <div class="row justify-content-md-center mt-lg-5">

                <div class="col-md-5">
                    <h1>Registrace</h1>

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
                            <label for="username" class="form-label fw-bold">Uživatelské jméno:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required/><br />
                        </div>

                        <div class="mb-0">
                            <label for="email" class="form-label fw-bold" >E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required/><br />
                        </div>

                        <div class="mb-0">
                            <label for="heslo" class="form-label fw-bold">Heslo:</label>
                            <input type="password" class="form-control" name="heslo" id="heslo" value="<?php echo isset($_POST['heslo']) ? htmlspecialchars($_POST['heslo']) : ''; ?>" required/><br />
                        </div>

                        <div class="mb-0">
                            <label for="heslo2" class="form-label fw-bold">Potvrzení hesla:</label>
                            <input type="password" class="form-control" name="heslo2" id="heslo2" value="<?php echo isset($_POST['heslo2']) ? htmlspecialchars($_POST['heslo2']) : ''; ?>" required/><br />
                        </div>


                        <button type="submit" class="btn btn-primary">Registrovat se</button>
                        <a href="login.php" class="btn btn-outline-primary">Již mám účet</a>

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>