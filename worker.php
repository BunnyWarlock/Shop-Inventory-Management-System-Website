<?php
if (!array_key_exists("user_id", $_SESSION)){
  header("Location: login.php");
  exit;
}
$mysqli = require __DIR__ . "/userDB.php";

$sql = "select ID, Name, Email, role_name
  from users, role where ID = u_id and shop in (select shop from role
  where u_id = {$_SESSION["user_id"]})";
$result = $mysqli->query($sql);

if($result== true){
 if ($result->num_rows > 0) {
    $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
    $msg= $row;
 } else {
    $msg= "No Workers in the Shop!";
 }
}else{
  $msg= mysqli_error($db);
}

$fetchData = $msg;
?>
