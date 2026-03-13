<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $building_id = (int)$_POST['building_id'];
    $floor_number = (int)$_POST['floor_number'];
    $room_name = mysqli_real_escape_string($conn, $_POST['room_name']);

    if ($action == 'add') {
        // បន្ថែមបន្ទប់ថ្មី
        $query = "INSERT INTO rooms (building_id, floor_number, room_name) 
                  VALUES ($building_id, $floor_number, '$room_name')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: ../views/rooms/index.php?status=success&msg=RoomAdded");
        } else {
            header("Location: ../views/rooms/index.php?status=error");
        }

    } elseif ($action == 'edit') {
        // កែសម្រួលបន្ទប់ដែលមានស្រាប់
        $room_id = (int)$_POST['room_id'];
        $query = "UPDATE rooms SET 
                  building_id = $building_id, 
                  floor_number = $floor_number, 
                  room_name = '$room_name' 
                  WHERE id = $room_id";

        if (mysqli_query($conn, $query)) {
            header("Location: ../views/checkroom/buildings.php?status=success&msg=RoomUpdated");
        } else {
            header("Location: ../views/checkroom/buildings.php?status=error");
        }
    }
    exit();
}