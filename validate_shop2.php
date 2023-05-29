<?php
$mysqli = require __DIR__ . "/userDB.php";
$sql = sprintf("select * from shop where Name = '%s'",
              $mysqli->real_escape_string($_GET["shop"]));
$result = $mysqli->query($sql);
$is_available = $result->num_rows !== 0;
header("Content-Type: application/json");
echo json_encode(["available" => $is_available]);
?>
