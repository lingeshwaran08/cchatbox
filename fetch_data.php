<?php
include "db.php";

if (isset($_GET['category_id'])) {
    // Fetch subcategories based on category_id
    $category_id = $_GET['category_id'];
    $stmt = $conn->prepare("SELECT id, name FROM subcategories WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
} elseif (isset($_GET['subcategory_id'])) {
    // Fetch options based on subcategory_id
    $subcategory_id = $_GET['subcategory_id'];
    $stmt = $conn->prepare("SELECT id, name FROM options WHERE subcategory_id = ?");
    $stmt->bind_param("i", $subcategory_id);
} elseif (isset($_GET['option_id'])) {
    // Fetch answer based on option_id
    $option_id = $_GET['option_id'];
    $stmt = $conn->prepare("SELECT answer_text FROM answers WHERE option_id = ?");
    $stmt->bind_param("i", $option_id);
} else {
    // Fetch all categories (default view)
    $stmt = $conn->prepare("SELECT id, name FROM categories");
}

$stmt->execute();
$result = $stmt->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>
