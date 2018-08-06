<?php
include_once 'resource/Database.php';
include_once 'resource/utilities.php';

// process the form
if (isset($_POST['signupBtn'])) {
  // initialize an array to store any error message from the form
  $form_errors = array();

  // form validation
  $required_fields = array('email', 'username', 'password');

  // loop through the required fields array
  $form_errors = check_empty_fields($required_fields);

  // Fields that require checking for minimum length
  $fields_to_check_length = array('username' => 4, 'password' => 6);
  // call the function to check minimum required length and merge the return data into form_error array
  $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

  // email validation / merge the return data into form_error array
  $form_errors = array_merge($form_errors, check_email($_POST));

  // collect form data and store it in variables
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (checkDuplicateUsername($username, $db)) {
    $formErrorHTML = statusMessage("The username is already taken.");
  }
  // only process the form data and insert a new record to the database
  // if the error array is empty
  else if (empty($form_errors)) {

    // store a hash of the password, not the password itself
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
      $sqlInsert = "INSERT INTO users (username, password, email, join_date)
                    VALUES (:username, :password, :email, now())";

      $sqlStatement = $db->prepare($sqlInsert);

      $sqlStatement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));

      if ($sqlStatement->rowCount() == 1) {
        $formErrorHTML = statusMessage("Registration Successful", false);
      }
    } catch (PDOException $exception) {
        $formErrorHTML = statusMessage("An error ocurred: " . $exception->getMessage());
    }
  } else {              // ! empty($form_errors)
    if (count($form_errors) == 1) {
      $formErrorHTML = statusMessage("There is one error in the form.");
    } else {    // ! count($form_errors == 1)
      $formErrorHTML = statusMessage("There were " . count($form_errors) . " errors in the form.");
    } // end if (count($form_errors) == 1) {
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


<?php if(isset($formErrorHTML)) echo $formErrorHTML; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

<form method="post" action="">
  <table>
      <tr><td>Email:</td> <td><input type="text" value="" name="email"></td></tr>
      <tr><td>Username:</td> <td><input type="text" value="" name="username"></td></tr>
      <tr><td>Password:</td> <td><input type="password" value="" name="password"></td></tr>
      <tr><td></td> <td><input style="float:right;" type="submit" value="Sign Up" name="signupBtn"></td></tr>
  </table>
</form>
<p> <a href="index.php">Back</a> </p>

</body>
</html>
