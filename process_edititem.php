<?php
$mysqli = require __DIR__ . "/userDB.php";
$sql = "update item set Name = ?, CostPrice = ?, SellingPrice = ?, Min_amount = ?, Max_amount = ? where ID = ?";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("ssssss",
                  $_POST["name"],
                  $_POST["cp"],
                  $_POST["sp"],
                  $_POST["mina"],
                  $_POST["maxa"],
                  $_POST["id"]);

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
