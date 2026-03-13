<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_university"; // ត្រូវតែដូចឈ្មោះខាងលើ

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("ការភ្ជាប់ Database បរាជ័យ: " . mysqli_connect_error());
}

// កំណត់ឱ្យអានអក្សរខ្មែរបានត្រឹមត្រូវ
mysqli_set_charset($conn, "utf8mb4");
?>