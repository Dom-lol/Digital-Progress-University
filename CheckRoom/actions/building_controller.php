<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'add') {
        $building_name = mysqli_real_escape_string($conn, $_POST['building_name']);
        $totalfloor = (int)$_POST['totalfloor'];

        $query = "INSERT INTO buildings (building_name, totalfloor) VALUES ('$building_name', $totalfloor)";
        
      if (mysqli_query($conn, $query)) {
    // បាញ់ត្រឡប់មកទំព័រ building.php វិញ
    header("Location: ../../buildings.php?status=success");
} else {
    header("Location: ../../buildings.php?status=error&msg=" . urlencode(mysqli_error($conn)));
}
exit();
    }
    exit();
}