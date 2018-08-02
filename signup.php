<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Register Page</title>
</head>
<body>
<h2>User Authentication System </h2><hr>

<h3> Registration Form </h3>

<?php
var_dump($_POST);
?>

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
