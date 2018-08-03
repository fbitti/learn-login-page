<?php
include_once 'resource/Database.php';

// process the form
if (isset($_POST['signupBtn'])) {
  // initialize an array to store any error message from the form
  $form_errors = array();

  // form validation
  $required_fields = array('email', 'username', 'password');

  // loop through the required fields array
  foreach($required_fields as $name_of_field) {
    if (!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL) {
      $form_errors[] = $name_of_field;
    }
  }

  // only process the form data and insert a new record to the database
  // if the error array is empty
  if (empty($form_errors)) {
    // collect form data and store it in variables
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // store a hash of the password, not the password itself
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
  } else {              // ! empty($form_errors)
    if (count($form_errors) == 1) {
      // create an error message in the singular
      $formErrorHTML = "<p style='color:red;'> This form field is empty:<br>";
    } else {            // ! (count($form_errors) == 1)
      // create an error message in the plural
      $formErrorHTML = "<p style='color:red;'> These " . count($form_errors) . " form fields are empty.<br>";
    }
    $formErrorHTML .= "<ul style='color: red;'>";
    // loop through the error array and display all items
    foreach ($form_errors as $error) {
      $formErrorHTML .= "<li> {$error} </li>";
    }
    $formErrorHTML .= "</ul></p>";

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


<?php if(isset($sqlResult)) echo $sqlResult; ?>

<?php if(isset($formErrorHTML)) echo $formErrorHTML; ?>

<form method="post" action="">
  <table>
      <tr><td>Email:</td> <td><input type="text" value="" name="email"></td></tr>
      <tr><td>Username:</td> <td><input type="text" value="" name="username"></td></tr>
      <tr><td>Password:</td> <td><input type="password" value="" name="password"></td></tr>
      <tr><td></td> <td><input style="float:right;" type="submit" value="Sign Up" name="signupBtn"></td></tr>
  </table>

<p> <a href="index.php">Back</a> </p>

</body>
</html>
