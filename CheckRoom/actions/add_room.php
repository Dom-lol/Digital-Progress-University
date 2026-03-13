<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $b_id   = (int)$_POST['building_id'];
    $r_name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $floor  = (int)$_POST['floor_number'];

    if ($b_id > 0 && !empty($r_name)) {
        // ឆែកមើលក្រែងលោមានឈ្មោះបន្ទប់នេះក្នុងអគារនេះរួចហើយ
        $check = mysqli_query($conn, "SELECT id FROM rooms WHERE building_id = '$b_id' AND room_name = '$r_name' LIMIT 1");
        
        if (mysqli_num_rows($check) == 0) {
            $sql = "INSERT INTO rooms (building_id, room_name, floor_number) VALUES ('$b_id', '$r_name', '$floor')";
            mysqli_query($conn, $sql);
            header("Location: ../views/checkroom/buildings.php?success=room_added");
        } else {
            header("Location: ../views/checkroom/buildings.php?error=room_exists");
        }
    }
}
exit;