<?php
include "db.php";

$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : die(json_encode(["error" => "Subcategory ID required"]));

$stmt = $conn->prepare("SELECT * FROM options WHERE subcategory_id = ?");
$stmt->bind_param("i", $subcategory_id);
$stmt->execute();
$result = $stmt->get_result();

$options = [];
while ($row = $result->fetch_assoc()) {
    $options[] = $row;
}

echo json_encode($options);
?>
