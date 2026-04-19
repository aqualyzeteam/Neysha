<?php
$host     = "localhost"; 
$db_name  = "u724651910_db_aqualyze"; 
$db_user  = "u724651910_admin_aqualyze";  
$db_pass  = "Aqualyze2026!@"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
