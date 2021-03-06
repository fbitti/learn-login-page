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

  if (checkDuplicateEntries($db, "users", "username", $username)) {
    $formErrorHTML = statusMessage("This username is already taken.");
  }
  else if (checkDuplicateEntries($db, "users", "email", $email)) {
    $formErrorHTML = statusMessage("This email address is already registered.");
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

<?php
$page_title = "User Authentication - Registration Form";
include_once "partials/headers.php";
?>

<div class="container">
  <section class="col col-lg-7 flag">
    <h2>Registration Form</h2>
    <hr>

    <?php if(isset($formErrorHTML)) echo $formErrorHTML; ?>
    <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

    <form method="post" action="">
      <div class="form-group">
        <label for="emailField">Email: </label>
        <input type="text" class="form-control" id="emailField" aria-describedby="emailHelp" placeholder="Type your email" name="email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="usernameField">Username: </label>
        <input type="text" class="form-control" id="usernameField" placeholder="Choose a username" name="username">
      </div>
      <div class="form-group">
        <label for="passwordField">Password: </label>
        <input type="password" class="form-control" id="passwordField" placeholder="Choose a password" name="password">
      </div>
      <div class="d-flex">
        <p> </p>
        <button type="submit" class="btn btn-primary ml-auto" name="signupBtn">Sign Up</button>
      </div>
    </form>
  </section>
  <p> <a href="index.php">Back</a> </p>
</div>

<?php
include_once "partials/footers.php";
?>
