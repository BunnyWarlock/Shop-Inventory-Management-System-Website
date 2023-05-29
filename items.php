<?php
if (!array_key_exists("user_id", $_SESSION)){
  header("Location: login.php");
  exit;
}
$mysqli = require __DIR__ . "/userDB.php";

$sql = "select ID, Name, CostPrice, SellingPrice, Min_amount, Max_amount, amount
  from item, inventory where item.Shop in (select shop from role
  where u_id = {$_SESSION["user_id"]}) and inventory.item_id = item.ID";
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
