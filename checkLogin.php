<?php


if(empty($_SESSION['uzivatel_id'])){
    header('Location: login.php');
}