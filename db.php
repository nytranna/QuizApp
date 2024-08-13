<?php
/** @var \PDO $db - připojení k databázi */
$db = new PDO('mysql:host=127.0.0.1;dbname=quizapp;charset=utf8', 'root', 'mysql');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//ae3Aib4poeM9hei7ca