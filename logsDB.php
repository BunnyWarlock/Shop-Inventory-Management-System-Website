<?php
if (!array_key_exists("user_id", $_SESSION)){
  header("Location: login.php");
  exit;
}
$mysqli = require __DIR__ . "/userDB.php";

$sql = "select dateNTime, item.Name as iName, users.Name as uName, type, quantity, SellingPrice, CostPrice 
from transaction, item, users
where transaction.shop in (select shop from role where u_id = {$_SESSION["user_id"]}) and item.ID=item_id and users.ID=u_id";
$result = $mysqli->query($sql);

if($result== true){
 if ($result->num_rows > 0) {
    $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
    $msg= $row;
 } else {
    $msg= "No Item in Shop Inventory";
 }
}else{
  $msg= mysqli_error($db);
}

$fetchData = $msg;
?>
