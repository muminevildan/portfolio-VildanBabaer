<?php
$host = "localhost";
$kullanici = "root";
$sifre = "";
$veritabani = "portfolyo";

try {
    $db = new PDO("mysql:host=$host;dbname=$veritabani;charset=utf8", $kullanici, $sifre);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}
?>