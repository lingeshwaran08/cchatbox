<?php
include "db.php";

$option_id = isset($_GET['option_id']) ? $_GET['option_id'] : die(json_encode(["error" => "Option ID required"]));

$stmt = $conn->prepare("SELECT answer_text FROM answers WHERE option_id = ?");
$stmt->bind_param("i", $option_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["answer" => $row['answer_text']]);
} else {
    echo json_encode(["answer" => "No response available"]);
}
?>
