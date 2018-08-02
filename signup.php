<?php
include_once 'resource/Database.php';

if (isset($_POST['email'])) {
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  try {
    $sqlInsert = "INSERT INTO users (username, password, email, join_date)
                  VALUES (:username, :password, :email, now())";

    $sqlStatement = $db->prepare($sqlInsert);

    $sqlStatement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));

    if ($sqlStatement->rowCount() == 1) {
      $sqlResult = "<p style='padding:20px; color:green;'>Registration Successful</p>";
    }

  } catch (PDOException $exception) {
      $sqlResult = "<p style='padding:20px; color:red;'>Registration Failed: " . $exception->getMessage() . "</p>";

  }


}

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Register Page</title>
</head>
<body>
<h2>User Authentication System </h2><hr>

<h3> Registration Form </h3>


<?php if(isset($sqlResult)) echo $sqlResult ?>
<form method="post" action="">
  <table>
      <tr><td>Email:</td> <td><input type="text" value="" name="email"></td></tr>
      <tr><td>Username:</td> <td><input type="text" value="" name="username"></td></tr>
      <tr><td>Password:</td> <td><input type="password" value="" name="password"></td></tr>
      <tr><td></td> <td><input style="float:right;" type="submit" value="Sign Up"></td></tr>
  </table>

<p> <a href="index.php">Back</a> </p>

</body>
</html>
