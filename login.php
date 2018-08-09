<?php
include_once "resource/session.php";
include_once "resource/Database.php";
include_once "resource/utilities.php";

if ( isset($_POST["loginBtn"]) ) {
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
        redirectTo("index");
      } else {   // !password_verify($password, $hashed_password)
        $formErrorHTML = statusMessage("Invalid username or password.");
      } // end if (password_verify($password, $hashed_password))
    } // end while ($row = $sqlStatement->fetch())
  } else {    // ! empty($form_errors)
    if (count($form_errors) == 1) {
      $formErrorHTML = statusMessage("There is one error in the form.");
    } else {    // ! count($form_errors == 1)
      $formErrorHTML = statusMessage("There were " . count($form_errors) . " errors in the form.");
    } // end if (count($form_errors) == 1) {
  } // end else if (empty($form_errors)) {
} // end if ( isset($_POST["loginBtn"]) ) {


 ?>


<?php
$page_title = "User Authentication - Login Form";
include_once "partials/headers.php";
?>

<div class="container">
  <section class="col col-lg-7 flag">
    <h2>Login Form</h2>
    <hr>

    <?php if(isset($formErrorHTML)) echo $formErrorHTML; ?>
    <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

    <form method="post" action="">
      <div class="form-group">
        <label for="usernameField">Username: </label>
        <input type="text" class="form-control" id="usernameField" placeholder="Enter your username" name="username">
      </div>
      <div class="form-group">
        <label for="passwordField">Password: </label>
        <input type="password" class="form-control" id="passwordField" placeholder="Enter your password" name="password">
      </div>
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" class="form-check-input" name="remember"> Remember me
        </label>
      </div>
      <div class="d-flex">
        <a class="align-self-center" href="forgot_password.php">Forgot Password?</a>
        <button type="submit" class="btn btn-primary ml-auto" name="loginBtn">Sign In</button>
      </div>
    </form>
  </section>
  <p> <a href="index.php">Back</a> </p>
</div>


<?php
include_once "partials/footers.php";
?>
