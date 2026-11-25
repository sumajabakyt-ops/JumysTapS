<?php

// Сессияны бастау
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Дерекқор параметрлері
$host = "localhost";
$dbname = "jumystaps_db";
$username = "root";
$password = "";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Қателерді өңдеу
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    // Дайындалған сұраныстар
    $pdo->setAttribute(
        PDO::ATTR_EMULATE_PREPARES,
        false
    );

} catch (PDOException $e) {

    die("Дерекқорға қосылу қатесі: " . $e->getMessage());

}

?>
