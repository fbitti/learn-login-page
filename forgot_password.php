<?php
include_once 'resource/Database.php';
include_once 'resource/utilities.php';

if (isset($_POST['passwordResetBtn'])) {
  // initialize an array to store any error message from the form
  $form_errors = array();

  // form validation
  $required_fields = array('email', 'new_password', 'confirm_password');

  // call the function to check empty field and add the data to the form errors
  $form_errors = check_empty_fields($required_fields);

  // fields that require checking for minimum length
  $fields_to_check_length = array('new_password' => 6, 'confirm_password' => 6);

  // call the function to check minimum required length and merge the returned errors into the form errors array
  $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

  // email validation / merge the returned errors into the form errors array
  $form_errors = array_merge($form_errors, check_email($_POST));

  // check whether the errors array is empty, if so process the form data and insert the record into the database
  if (empty($form_errors)) {
    // collect the form data and store them in variables
    $email = $_POST['email'];
    $password1 = $_POST['new_password'];
    $password2 = $_POST['confirm_password'];

    // check if the passwords are not the same
    if ($password1 != $password2) {
      $sqlResult = "<p style='padding: 20px; border: 1px solid gray; color: red;'> New password and confirm password do not match. </p>";
    } else { // ! $password1 != $password2
      try {
        // create SQL select statement to verify if the email address exists in our database
        $sqlQuery = "SELECT email FROM users WHERE email = :email";

        // use PDO 'prepare' to sanitize the data
        $sqlStatement = $db->prepare($sqlQuery);

        // execute the SQL query
        $sqlStatement->execute(array(':email' => $email));

        // check whether the record exists
        if ($sqlStatement->rowCount() == 1) {
          // hash the password
          $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

          // SQL statement to update password
          $sqlUpdate = "UPDATE users SET password = :password WHERE email = :email";
          // use PDO 'prepare' to sanitize the data
          $sqlStatement = $db->prepare($sqlUpdate);

          // execute the statement
          $sqlStatement->execute(array(':password' => $hashed_password, ':email' => $email));

          $sqlResult = "<p style='padding: 20px; border: 1px solid gray; color: green;'> Password Reset Successful. </p>";

        } else { // ! $sqlStatement->rowCount() == 1
          $sqlResult = "<p style='padding: 20px; border: 1px solid gray; color: red;'>The email address provided does not exist in our database, please try again.</p>";
        } // end if ($sqlStatement->rowCount() == 1) {
      } catch (PDOException $exception) {
        $sqlResult = "<p style='padding: 20px; border: 1px solid gray; color: red;'>A database error ocurred: " . $exception->getMessage() . "</p>";
      } // try ... catch
    } // end if ($password1 != $password2) {

  } // end if (empty($form_errors)) {

} // end if (isset($_POST['passwordResetBtn'])) {

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Password Reset Form</title>
</head>
<body>
<h2>User Authentication System </h2><hr>

<h3> Password Reset Form </h3>


<?php if(isset($sqlResult)) echo $sqlResult; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

<form method="post" action="">
  <table>
      <tr><td>Email:</td> <td><input type="text" value="" name="email"></td></tr>
      <tr><td>New Password:</td> <td><input type="password" value="" name="new_password"></td></tr>
      <tr><td>Confirm Password:</td> <td><input type="password" value="" name="confirm_password"></td></tr>
      <tr><td></td> <td><input style="float:right;" type="submit" value="Reset Password" name="passwordResetBtn"></td></tr>
  </table>
</form>
<p> <a href="index.php">Back</a> </p>
</body>
</html>
