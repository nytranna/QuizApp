<?php

session_start();


include 'header.php';

require_once __DIR__.'/QuestionRepository.php';
$questionRepository = new QuestionRepository();

require_once __DIR__.'/CategoryRepository.php';
$categoryRepository = new CategoryRepository();

$questions = $questionRepository->selectAllQuestions();
$category = $categoryRepository->selectCategory();


?>


<div class="container">

    <h1 class="mb-3">Otázky</h1>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Kategorie</th>
            <th scope="col">Otázka</th>
            <th scope="col">a)</th>
            <th scope="col">b)</th>
            <th scope="col">c)</th>
            <th scope="col">d)</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php if (!empty($questions)): ?>

            <?php foreach ($questions as $q): ?>

                <?php
                    $categoryName = null;
                    $categoryId = $q['category_id'];
                    foreach ($category as $c) {
                        if ($c['id'] == $categoryId) {
                            $categoryName = htmlspecialchars($c['name']);
                            break;
                        }
                    }
                ?>

                <tr>
                    <td><?php echo htmlspecialchars($categoryName); ?></td>
                    <td><?php echo htmlspecialchars($q['question']); ?></td>
                    <td><?php echo htmlspecialchars($q['option_a']); ?></td>
                    <td><?php echo htmlspecialchars($q['option_b']); ?></td>
                    <td><?php echo htmlspecialchars($q['option_c']); ?></td>
                    <td><?php echo htmlspecialchars($q['option_d']); ?></td>
                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="6">
                    <p>Žádné otázky k zobrazení.</p>
                </td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>

</div>



