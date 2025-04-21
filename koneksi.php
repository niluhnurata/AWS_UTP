<?php
$host = "database-niluh.cpmv586harxf.us-east-1.rds.amazonaws.com";
$port = 3306;
$dbname = "database-niluh";
$username = "admin";
$password = "NiluhNurata04";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
echo "Koneksi berhasil ke database!";
?>
