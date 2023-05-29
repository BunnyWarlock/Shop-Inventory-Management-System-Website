<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST"){
  $mysqli = require __DIR__ . "/userDB.php";
  $sql = sprintf("select * from users where email = '%s'",
                $mysqli->real_escape_string($_POST["email"]));
  $result = $mysqli->query($sql);
  $user = $result->fetch_assoc();

  if ($user){
    if (password_verify($_POST["password"], $user["PassHash"])){
      session_start();
      session_regenerate_id();
      $_SESSION["user_id"] = $user["ID"];
      header("Location: index.php");
      exit;
    }
  }
  $is_invalid = true;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SIMS: Log In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/style2.css">
  </head>

  <body>
    <div class="bg">
      <img src="img/background.jpg" alt="Background image">
    </div>

    <nav>
      <h3 style="padding-right: 20px !important;">SIMS: </h3>
      <a href="login.php"><button style="padding: 0px 20px 0px 20px !important;">
        <h3 style="padding:0; margin:0;">Log In</h3></button></a>
      <h3 style="padding: 0px 20px 0px 20px !important;"> or </h3>
      <a href="signup.html"><button style="padding: 0px 0px 0px 20px !important;">
        <h3 style="padding:0; margin:0;">Sign Up</h3></button></a>
    </nav>

    <div class="body">
      <div class="header">
        <h1 span style="margin:0; padding:0; font-size:75px; color: #fec89a;">SIMS</h1>
        <h3 style="margin: 0; padding: 0; color: #cbc8c7;"><u>Shop Inventory Managment System</u></h3>
        <br>
      </div>

      <h1 style="margin:0; padding:0; color: #cbc8c7;">Log In</h1>
      <?php if ($is_invalid): ?>
        <em style="color:red">Invalid Log In Credentials</em>
      <?php endif; ?>

      <form method="post">
        <div>
          <label for="email">Email</label>
          <input type="email" id="email" name="email"  placeholder="Enter your email"
                 value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                 style="margin-right: 0px !important; width: 100%">
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password"
                 style="margin-right: 0px !important; width: 100%">
        </div>

        <div class="header">
          <button style="margin:10; padding:10; background-color: rgba(0, 0, 0, 0.0); border: none;">
            <br><h3 style="margin:0; padding:0; color: #fec89a;">Log In</h3>
          </button>
        </div>
      </form>
    </div>

    <footer style="display: flex; justify-content: center; border: none;">
      <img class="logo" src="img/logo.jpg" alt="logo" height="50" width="50" style="border-radius:5px; margin: auto; opacity: 50%;">
    </footer>

  </body>
</html>
