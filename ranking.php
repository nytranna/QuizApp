<?php
session_start();

include 'header.php';

require_once __DIR__.'/UserRepository.php';
$userRepository = new UserRepository();

require_once __DIR__.'/QuizQuestionRepository.php';
$quizQuestionRepository = new QuizQuestionRepository();

$usersPoints = [];

$users = $userRepository->selectAllUsers();

foreach ($users as $user) {
    $answers = $quizQuestionRepository->selectAnswers($user['id']);
    $points = count($answers);

    $usersPoints[$user['username']] = $points;
}

arsort($usersPoints);

?>

<div class="container">
    <h1>Žebříček</h1>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Uživatel</th>
            <th scope="col">Body</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php
        $i = 1;
        foreach ($usersPoints as $username => $points):
            ?>
            <tr>
                <th scope="row"><?php echo $i?></th>
                <td><?php echo htmlspecialchars($username); ?></td>
                <td><?php echo htmlspecialchars($points); ?></td>
            </tr>

            <?php
            $i++;
        endforeach;
        ?>

        </tbody>
    </table>

</div>
</body>
</html>