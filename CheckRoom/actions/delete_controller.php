<?php
require_once __DIR__ . '/../config/db.php';

$type = $_GET['type'] ?? '';
$id = (int)$_GET['id'] ?? 0;

if ($id > 0) {
    if ($type === 'room') {
        // លុបតែបន្ទប់
        $sql = "DELETE FROM rooms WHERE id = $id";
    } elseif ($type === 'building') {
        // លុបអគារ ត្រូវលុបគ្រប់បន្ទប់ដែលនៅក្រោមអគារនោះជាមុន (Foreign Key Safety)
        mysqli_query($conn, "DELETE FROM rooms WHERE building_id = $id");
        $sql = "DELETE FROM buildings WHERE id = $id";
    }
    
    if (mysqli_query($conn, $sql)) {
        header("Location: ../views/checkroom/buildings.php?status=deleted");
    } else {
        header("Location: ../views/checkroom/buildings.php?status=error");
    }
}