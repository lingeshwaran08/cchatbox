<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "db.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $query = isset($_GET['query']) ? $_GET['query'] : '';

    $stmt = $conn->prepare("SELECT response FROM queries WHERE query LIKE ?");
    $search = "%" . $query . "%";
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["response" => $row['response']]);
    } else {
        echo json_encode(["response" => "Sorry, I don't understand that question."]);
    }
}
?>
