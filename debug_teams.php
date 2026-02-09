<?php
$conn = new mysqli('127.0.0.1', 'direktorat_tmb', 'Lpprri_@1945', 'csirt_rri');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$result = $conn->query("SELECT id, name, photo FROM teams LIMIT 10");
while($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | Name: " . $row['name'] . " | Photo: " . $row['photo'] . "\n";
}
$conn->close();
?>
