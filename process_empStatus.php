<?php
$mysqli = require __DIR__ . "/userDB.php";
$sql = "update role set role_name = ? where u_id = ?";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("ss",
                  $_POST["status"],
                  $_POST["id"]);

try {
    if ($stmt->execute()) {
        header("Location: Employee.php");
        exit;
    } else {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
      die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}
?>
