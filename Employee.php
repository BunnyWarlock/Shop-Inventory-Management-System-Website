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
}

include("worker.php");
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SIMS: Employee</title>
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
            <h1 style="margin:0; padding:0;">Inventory: <?= htmlspecialchars($shop["shop"]) ?> Shop</h1>
            <div class="input_group">
              <input type="search" placeholder="Search Item...">
              <img src="img/search.svg" alt="">
            </div>
          </section>

          <section class="table_body">
            <table>
              <thead><tr>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 No. <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Employee Name <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Email <span class="icon_arrow">&UpArrow;</span></b></h3></th>
               <th style="text-align:center;"><h3 style="margin:0; padding:0;"><b>
                 Status <span class="icon_arrow">&UpArrow;</span></b></h3></th>
             </tr></thead>

             <tbody>
              <?php
                if(is_array($fetchData)){
                $sn=1;
                foreach($fetchData as $data){
              ?>
              <tr data-href="empStatus.php?e_id=<?php echo($data['ID']) ?>">
                <td><?php echo $sn; ?></td>
                <td><?php echo $data['Name']??''; ?></td>
                <td><?php echo $data['Email']??''; ?></td>
                <td style="<?php if ($data['role_name'] == "PENDING") echo 'background-color: red;';
                                 elseif ($data['role_name'] == "CLERK") echo 'background-color: yellow;';
                                 elseif ($data['role_name'] == "MANAGER") echo 'background-color: green;';
                                 else echo 'background-color: blue;';?> opacity: 50%;">
                    <?php echo $data['role_name']??''; ?></td>
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



    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const rows = document.querySelectorAll("tr[data-href]");

        rows.forEach(row => {
            row.addEventListener("click", () => {
              window.location.href = row.dataset.href;
            });
        });
      });
    </script>

  </body>
</html>
