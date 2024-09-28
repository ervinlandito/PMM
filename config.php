<?php
// Memuat autoloader dari Composer
require_once __DIR__ . '/vendor/autoload.php';

// Memuat file .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Mengambil variabel dari file .env
$db_server = $_ENV['DB_SERVER'];
$db_username = $_ENV['DB_USERNAME'];
$db_password = $_ENV['DB_PASSWORD'];
$db_name = $_ENV['DB_NAME'];

// Koneksi ke database menggunakan variabel dari .env
$con = mysqli_connect($db_server, $db_username, $db_password, $db_name);

// Periksa koneksi
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
