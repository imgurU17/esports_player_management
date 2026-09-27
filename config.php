<?php

session_start();

$host = "localhost";
$db   = "esports_manager";
$user = "root";
$pass = "";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Database Connection Failed: " . $e->getMessage());

}

function require_login()
{
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit;
    }
}
?>