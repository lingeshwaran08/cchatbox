<?php
include "db.php";

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die(json_encode(["error" => "Category ID required"]));

$stmt = $conn->prepare("SELECT * FROM subcategories WHERE category_id = ?");
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

$subcategories = [];
while ($row = $result->fetch_assoc()) {
    $subcategories[] = $row;
}

echo json_encode($subcategories);
?>
