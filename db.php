<?php

$host = 'localhost';
$db = 'unselstore';
$user = 'root'; // замените на свой логин
$pass = '';     // замените на свой пароль
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>