<?php
// ថយក្រោយ ១ កម្រិត ព្រោះ actions និង config នៅក្បែរគ្នា
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['csv_data'])) {
    
    $data = json_decode($_POST['csv_data'], true);
    
    if (is_array($data)) {
        mysqli_begin_transaction($conn);
        try {
            foreach ($data as $row) {
                $b_name = mysqli_real_escape_string($conn, $row[0]);
                $b_total = (int)$row[1];
                $r_floor = (int)$row[2];
                $r_name = mysqli_real_escape_string($conn, $row[3]);

                // ឆែកអគារ
                $res = mysqli_query($conn, "SELECT id FROM buildings WHERE building_name = '$b_name' LIMIT 1");
                if ($row_b = mysqli_fetch_assoc($res)) {
                    $b_id = $row_b['id'];
                } else {
                    mysqli_query($conn, "INSERT INTO buildings (building_name, totalfloor) VALUES ('$b_name', '$b_total')");
                    $b_id = mysqli_insert_id($conn);
                }

                // បញ្ចូលបន្ទប់
                if (!empty($r_name)) {
                    mysqli_query($conn, "INSERT INTO rooms (building_id, room_name, floor_number) VALUES ('$b_id', '$r_name', '$r_floor')");
                }
            }
            mysqli_commit($conn);
            // ត្រឡប់ទៅទំព័រដើមវិញ (កែ Path តាមរចនាសម្ព័ន្ធពិត)
            header("Location: ../views/checkroom/buildings.php?success=1");
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "No data received!";
}