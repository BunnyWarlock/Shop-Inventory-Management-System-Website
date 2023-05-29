<?php
if (empty($_POST["name"]))
  die("Name is required");

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
  die("Enter a valid Email address");

if (strlen($_POST["password"]) < 8)
  die("Password must at least be 8 characters long");
if (!preg_match("/[a-z]/i", $_POST["password"]))
  die("Password must contain at least 1 letter");
if (!preg_match("/[0-9]/", $_POST["password"]))
  die("Password must contain at least 1 digit");

if ($_POST["password2"] !== $_POST["password"])
  die("Passwords does not match");

$pass_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

if (empty($_POST["admin"]))
  die("Please select if you are creating a new shop or connecting to an existing one");

if (empty($_POST["shop"]))
  die("Shop name is required");

$mysqli = require __DIR__ . "/userDB.php";
$sql = "select * from shop where Name = ?";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("s", $_POST["shop"]);

try {
    if (!$stmt->execute()) {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
    die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}

$result = $stmt->get_result();
if ($result->num_rows > 0) {
  if ($_POST["admin"] === "ADMIN")
    die("A Shop with this name already exist");
} else {
  if ($_POST["admin"] === "PENDING")
    die("No Shop with that name exist");
}
$stmt->close();

$sql = "insert into users(Name, Email, PassHash) values (?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $pass_hash);

try {
    if (!$stmt->execute()) {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        echo "Email already exists";
    } else {
        die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
    }
}



$sql = "select ID from users where Email = ?";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("s", $_POST["email"]);

try {
    if (!$stmt->execute()) {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
    die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();
$id = $row["ID"];



if ($_POST["admin"] === "ADMIN") {
  $currentDate = date('Y-m-d');
  $sql = "insert into shop(Name, owner_id, date_of_creation) values (?, ?, ?)";
  $stmt = $mysqli->stmt_init();
  if (!$stmt->prepare($sql))
    die("SQL Error: " . $mysqli->error);
  $stmt->bind_param("sss",
                    $_POST["shop"],
                    $id,
                    $currentDate);

  try {
      if (!$stmt->execute()) {
          die("Error executing the statement");
      }
  } catch (mysqli_sql_exception $e) {
      if ($e->getCode() == 1062) {
          echo "Shop name already exists";
      } else {
          die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
      }
  }
}



$sql = "insert into role(u_id, role_name, shop) values (?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql))
  die("SQL Error: " . $mysqli->error);
$stmt->bind_param("sss",
                  $id,
                  $_POST["admin"],
                  $_POST["shop"]);

try {
    if ($stmt->execute()) {
        header("Location: signup_success.html");
        exit;
    } else {
        die("Error executing the statement");
    }
} catch (mysqli_sql_exception $e) {
    die("Error executing the statement: " . $e->getMessage() . " (Error code: " . $e->getCode() . ")");
}
?>
