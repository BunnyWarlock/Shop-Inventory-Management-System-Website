<?php
$mysqli = require __DIR__ . "/userDB.php";
$sql = "delete from item where ID = ?";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("s", $_POST["id"]);

try {
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
      die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}
?>
