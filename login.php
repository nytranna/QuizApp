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


////-----
//require_once '/google-api-php-client-main/autoload.php';
//
//
//// Inicializace Google API klienta
//require_once 'vendor/autoload.php'; // Importuje Google API klienta
//$client = new Google_Client();
//$client->setAuthConfig('credentials.json'); // Nastaví cestu k vašemu JSON souboru s OAuth klientem
//$client->addScope(Google_Service_PeopleService::USERINFO_EMAIL); // Přidá požadovaný rozsah (scope)
//
//// Pokud uživatel klikne na přihlašovací odkaz, přesměrujte ho na Google OAuth autorizační stránku
//if (!isset($_GET['code'])) {
//    $auth_url = $client->createAuthUrl();
//    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
//} else {
//    // Zpracování autorizačního kódu po návratu z Google OAuth autorizační stránky
//    $client->fetchAccessTokenWithAuthCode($_GET['code']);
//    $token = $client->getAccessToken();
//
//    // Získání informací o přihlášeném uživateli
//    $oauth2 = new Google_Service_Oauth2($client);
//    $userInfo = $oauth2->userinfo->get();
//
//    // Zde můžete provést další akce, například ověření uživatele v databázi nebo vytvoření nového účtu
//
//    // Výpis informací o přihlášeném uživateli (pouze pro účely testování)
//    echo '<pre>';
//    print_r($userInfo);
//    echo '</pre>';
//}
//
//
////----


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