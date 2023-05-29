<?php
$mysqli = require __DIR__ . "/userDB.php";

$sql = "select amount from inventory where item_id = ?";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("s", $_POST["id"]);

try {
    if (!$stmt->execute()) {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
      die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();
$amount = $row["amount"];
$amount += ($_POST['type'] === "BUY") ? $_POST["quantity"] : -1 * $_POST["quantity"];



$sql = "update inventory set amount = ? where item_id = ?";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("ss",
                  $amount,
                  $_POST["id"]);

try {
    if (!$stmt->execute()) {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
      die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}


$currentDateTime = date('Y-m-d H:i:s');
$sql = "insert into transaction(dateNTime, item_id, shop, u_id, type, quantity) values (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("ssssss",
                  $currentDateTime,
                  $_POST["id"],
                  $_POST["shop"],
                  $_POST["u_id"],
                  $_POST["type"],
                  $_POST["quantity"],);

try {
    if ($stmt->execute()) {
        header("Location: transaction_select.php");
        exit;
    } else {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
      die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}
?>
