<?php
include_once "resource/session.php";
include_once "resource/Database.php";
include_once "resource/utilities.php";

if (isset($_POST["loginBtn"])) {
  // array to store the errors
  $form_errors = array();

  // validate
  $required_fields = array('username', 'password');
  $form_errors = check_empty_fields($required_fields);

  if (empty($form_errors)) {
    // store the form data in variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    // check if the user exists in the Database
    $sqlQuery = "SELECT * FROM users WHERE username = :username";
    $sqlStatement = $db->prepare($sqlQuery);
    $sqlStatement->execute(array(':username' => $username));

    while ($row = $sqlStatement->fetch()) {
      $id = $row['id'];
      $hashed_password = $row['password'];
      $username = $row['username'];

      if (password_verify($password, $hashed_password)) {
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $username;
        header("location: index.php");
      } else {   // !password_verify($password, $hashed_password)
        $formErrorHTML = "<p style='padding:20px; color:red; border: 1px solid grey;'> Invalid username or password. </p>";
      }
    }


  } else {    // ! empty($form_errors)
    if (count($form_errors) == 1) {
      $formErrorHTML = "<p style='color: red;'>There is one error in the form.</p>";
    } else {    // ! count($form_errors == 1)
      $formErrorHTML = "<p style='color: red;'>There were " . count($form_errors) . " errors in the form.</p>";
    }
  }
}


 ?>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>
<body>
<h2>User Authentication System </h2><hr>

<h3> Login Form </h3>

<?php if(isset($formErrorHTML)) echo $formErrorHTML; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form method="post" action="">
  <table>
      <tr><td>Username:</td> <td><input type="text" value="" name="username"></td></tr>
      <tr><td>Password:</td> <td><input type="password" value="" name="password"></td></tr>
      <tr><td></td> <td><input style="float:right;" type="submit" value="Signin" name="loginBtn"></td></tr>
  </table>

<p> <a href="index.php">Back</a> </p>

</body>
</html>
