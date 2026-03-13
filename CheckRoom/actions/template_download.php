<?php
// កំណត់ឈ្មោះឯកសារពេលទាញយក
$filename = "building_and_room_template_" . date('Y-m-d') . ".csv";

// កំណត់ Header ឱ្យ Browser ដឹងថាជាការ Download ឯកសារ CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// បើក output stream
$output = fopen('php://output', 'w');

// បន្ថែម BOM ដើម្បីឱ្យ Excel អានអក្សរខ្មែរបាន (បើចង់ដាក់អក្សរខ្មែរក្នុង Header)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// ១. បង្កើត Header តាមដែលលោកឪចង់បាន
// buildingname, totalfloor, floor, roomid
fputcsv($output, ['buildingname', 'totalfloor', 'floor', 'roomid']);

// ២. បន្ថែមទិន្នន័យគំរូ ១ ឬ ២ ជួរ ដើម្បីឱ្យអ្នកប្រើប្រាស់យល់
fputcsv($output, ['អគារ A', '5', '1', '101']);
fputcsv($output, ['អគារ A', '5', '1', '102']);
fputcsv($output, ['អគារ B', '3', '2', '201']);

fclose($output);
exit;
?>