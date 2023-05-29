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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SIMS: Add Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/style2.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="js/validation2.js" defer></script>
  </head>



  <body>
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

      <div class="body">
        <div class="header">
          <h1 span style="margin:0; padding:0; font-size:75px; color: #fec89a;"><?= htmlspecialchars($shop["shop"]) ?> Shop</h1>
          <h3 style="margin: 0; padding: 0; color: #cbc8c7;"><u>Add Item</u></h3>
          <br>
        </div>

        <h1 style="margin:0; padding:0; color: #cbc8c7;">Provide Item Information</h1>

        <form action="process_additem.php" method="post" id="item">
          <div>
            <input type='hidden' name='shop' value='<?php echo htmlspecialchars($shop["shop"]);?>'/>
          </div>
          <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name"  placeholder="Enter the name of the item"
                   style="margin-right: 0px !important; width: 100%">
          </div>
          <div>
            <label for="cp">Cost Price</label>
            <input type="number" id="cp" name="cp" placeholder="Enter the cost price of the item"
                   style="margin-right: 0px !important; width: 100%">
          </div>
          <div>
            <label for="sp">Selling Price</label>
            <input type="number" id="sp" name="sp" placeholder="Enter the selling price of the item"
                   style="margin-right: 0px !important; width: 100%">
          </div>
          <div>
            <label for="mina">Minimum Amount</label>
            <input type="number" id="mina" name="mina" placeholder="Enter the minimum amount of the item you like in your inventory"
                   style="margin-right: 0px !important; width: 100%">
          </div>
          <div>
            <label for="maxa">Maximum Amount</label>
            <input type="number" id="maxa" name="maxa" placeholder="Enter the maximum amount of the item you like in your inventory"
                   style="margin-right: 0px !important; width: 100%">
          </div>

          <div class="header">
            <button style="margin:10; padding:10; background-color: rgba(0, 0, 0, 0.0); border: none;">
              <br><h3 style="margin:0; padding:0; color: #fec89a;">Add Item to Inventory</h3>
            </button>
          </div>
        </form>
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
