<?php
$host = 'localhost';
$db   = 'testcicd_db'; // CHANGE THIS to your MilesWeb DB Name
$user = 'root';       // CHANGE THIS to your MilesWeb DB Username
$pass = '';           // CHANGE THIS to your MilesWeb DB Password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    try {
        $dsn_no_db = "mysql:host=$host;charset=$charset";
        $pdo = new PDO($dsn_no_db, $user, $pass, $options);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` ");
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e2) {
        die("Database Connection failed: " . $e2->getMessage() . "<br>Check your config.php credentials.");
    }
}

session_start();
?>
