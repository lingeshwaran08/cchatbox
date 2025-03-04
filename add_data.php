<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topic = $_POST['topic'];
    $subtopic = $_POST['subtopic'];
    $query = $_POST['query'];
    $response = $_POST['response'];

    $sql = "INSERT INTO topics (topic_name) VALUES ('$topic')";
    $conn->query($sql);
    $topic_id = $conn->insert_id;

    $sql = "INSERT INTO subtopics (topic_id, subtopic_name) VALUES ('$topic_id', '$subtopic')";
    $conn->query($sql);
    $subtopic_id = $conn->insert_id;

    $sql = "INSERT INTO queries (subtopic_id, query, response) VALUES ('$subtopic_id', '$query', '$response')";
    $conn->query($sql);

    echo "Data added successfully!";
}


?>
