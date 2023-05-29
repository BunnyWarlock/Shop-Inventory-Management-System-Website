<?php
session_start();

if (isset($_SESSION["user_id"])){
  $mysqli = require __DIR__ . "/userDB.php";
  $sql = "select * from users where id = {$_SESSION["user_id"]}";
  $result = $mysqli->query($sql);
  $user = $result->fetch_assoc();
  $sql = "select * from role where u_id = {$_SESSION["user_id"]}";
  $result = $mysqli->query($sql);
  $shop = $result->fetch_assoc();

  $str = "'BUY'";
  $sql = "select sum(quantity*CostPrice) as cost from transaction, item
          where item.ID=transaction.item_id and type={$str} and transaction.shop='{$shop["shop"]}'";
  $result = $mysqli->query($sql);
  $cost = $result->fetch_assoc();
  $str = "'SELL'";
  $sql = "select sum(quantity*SellingPrice) as revenue from transaction, item
          where item.ID=transaction.item_id and type={$str} and transaction.shop='{$shop["shop"]}'";
  $result = $mysqli->query($sql);
  $sell = $result->fetch_assoc();
}

include("logsDB.php");
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SIMS: Logs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/style2.css">
  </head>



  <body style="max-width: none; width: fit-content;">
    <div class="bg">
      <img src="img/background.jpg" alt="Background image">
    </div>

    <?php if (isset($user)): ?>
      <nav>
        <ul class="nav_links">
          <li><a href="index.php" style="text-decoration: none;"><h3>SIMS Home: <?= htmlspecialchars($user["Name"]) ?></h3></a></li>
          <?php if ($shop["role_name"] !== "PENDING"): ?>
            <?php if ($shop["role_name"] !== "CLERK"): ?>
              <li><a href="Employee.php" style="text-decoration: none;"><h3>Employee</h3></a></li>
              <?php if ($shop["role_name"] === "ADMIN" || $shop["role_name"] === "MANAGER" ): ?>
                <li><a href="additem.php" style="text-decoration: none;"><h3>Add Item</h3></a></li>
              <?php endif; ?>
            <?php endif; ?>
              <li><a href="transaction_select.php" style="text-decoration: none;"><h3>Transaction</h3></a></li>
              <li><a href="logs.php" style="text-decoration: none;"><h3>Logs</h3></a></li>
          <?php endif; ?>
        </ul>
        <a href="logout.php"><button style="padding: 0px 0px 0px 20px !important;">
          <h3 style="padding:0; margin:0;">Log Out</h3></button></a>
      </nav>



      <div class="body" style="max-width: none;">
        <?php echo $deleteMsg??''; ?>
        <main class="table">
          <section class="table_header">
            <h1 style="margin:0; padding:0;">Transaction Logs of <?= htmlspecialchars($shop["shop"]) ?> Shop</h1>
            <div class="input_group">
              <input type="search" placeholder="Search Item...">
              <img src="img/search.svg" alt="">
            </div>
          </section>

          <div>
            <h3 style="margin:0; padding:0;"><b>Total Costs:   $<?= ($cost["cost"] != null) ? htmlspecialchars($cost["cost"]) : 0 ?></b></h3>
            <h3 style="margin:0; padding:0;"><b>Total Revenue: $<?= ($sell["revenue"] != null) ? htmlspecialchars($sell["revenue"]) : 0 ?></b></h3>
            <h3 style="margin:0; padding:0;"><b>Total Profit:  $<?= htmlspecialchars($sell["revenue"] - $cost["cost"]) ?></b></h3>
          </div>

          <section class="table_body">
            <table>
              <thead><tr>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 No. <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Date and Time <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Item Name <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Type <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Quantity <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Recorder <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Cost Price <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Selling Price <span class="icon_arrow">&UpArrow;</span></b></h3></th>
             </tr></thead>

             <tbody>
              <?php
                if(is_array($fetchData)){
                $sn=1;
                foreach($fetchData as $data){
              ?>
              <tr>
                <td><?php echo $sn; ?></td>
                <td><?php echo $data['dateNTime']??''; ?></td>
                <td><?php echo $data['iName']??''; ?></td>
                <td><?php echo $data['type']??''; ?></td>
                <td><?php echo $data['quantity']??''; ?></td>
                <td><?php echo $data['uName']??''; ?></td>
                <td><?php echo $data['CostPrice']??''; ?></td>
                <td><?php echo $data['SellingPrice']??''; ?></td>
              </tr>
              <?php
              $sn++;}}else{ ?>
              <tr>
                <td colspan="8">
                <?php echo $fetchData; ?>
              </td>
              <tr>
                <?php
                }?>
            </tbody>
            </table>
          </section>
        </main>
        <script src="js/script.js"></script>
      </div>

    <?php else: ?>
      <nav>
        <h3 style="padding-right: 20px !important;">SIMS Home: </h3>
        <a href="login.php"><button style="padding: 0px 20px 0px 20px !important;">
          <h3 style="padding:0; margin:0;">Log In</h3></button></a>
        <h3 style="padding: 0px 20px 0px 20px !important;"> or </h3>
        <a href="signup.html"><button style="padding: 0px 0px 0px 20px !important;">
          <h3 style="padding:0; margin:0;">Sign Up</h3></button></a>
      </nav>
    <?php endif; ?>

    <footer style="display: flex; justify-content: center; border: none;">
      <img class="logo" src="img/logo.jpg" alt="logo" height="50" width="50" style="border-radius:5px; margin: auto; opacity: 50%;">
    </footer>

  </body>
</html>
