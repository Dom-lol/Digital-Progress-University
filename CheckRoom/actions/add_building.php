<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['building_name']);
    $floors = (int)$_POST['total_floors'];

    if (!empty($name)) {
        $sql = "INSERT INTO buildings (building_name, totalfloor) VALUES ('$name', '$floors')";
        if (mysqli_query($conn, $sql)) {
            header("Location: ../views/checkroom/buildings.php?success=added");
        } else {
            header("Location: ../views/checkroom/buildings.php?error=failed");
        }
    }
}
exit;