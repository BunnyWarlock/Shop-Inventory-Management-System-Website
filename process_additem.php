<?php
$mysqli = require __DIR__ . "/userDB.php";
$sql = "insert into item(Shop, Name, CostPrice, SellingPrice, Min_amount, Max_amount) values (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("ssssss",
                  $_POST["shop"],
                  $_POST["name"],
                  $_POST["cp"],
                  $_POST["sp"],
                  $_POST["mina"],
                  $_POST["maxa"]);

try {
    if (!$stmt->execute()) {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
      die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}



$sql = "select ID from item where Name = ? and Shop = ?";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("ss", $_POST["name"], $_POST["shop"]);

try {
    if (!$stmt->execute()) {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
    die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();
$i_id = $row["ID"];



$sql = "insert into inventory(item_id) values (?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("s", $i_id);

try {
    if ($stmt->execute()) {
        header("Location: additem.php");
        exit;
    } else {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
      die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}
?>
