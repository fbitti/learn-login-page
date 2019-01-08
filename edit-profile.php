<?php
$page_title = "User Authentication - Edit Profile";
include_once 'partials/headers.php';
include_once 'partials/parseProfile.php';
?>

<div class="container">
  <section class="col col-lg-7">
    <h2>Edit Profile</h2>
    <hr>
    <div>
      <?php if (isset($result)) echo $result; ?>
      <?php if (!empty($form_errors)) echo show_errors($form_errors); ?>
    </div>
    <div class="clearfix"></div>

    <?php if (!isset($_SESSION['username'])): ?>
      <p class="lead">You are not authorized to view this page <a href="login.php">Login</a>
        <br>
        Not yet a member? <a href="signup.php">Signup</a>
      </p>
    <?php else: ?>
      <form action="" method="post">
        <div class="form-group">
          <label for="emailField">Email</label>
          <input class="form-control" type="text" name="email" id="emailField" value="<?php if(isset($email)) echo $email; ?>">
        </div>

        <div class="form-group">
          <label for="usernameField">Username</label>
          <input class="form-control" type="text" name="username" id="usernameField" value="<?php if (isset($username)) echo $username; ?>">
        </div>
        <input type="hidden" name="hidden_id" value="<?php if (isset($id)) echo $id; ?>">
        <button class="btn btn-primary pull-right" type="submit" name="updateProfileBtn">Update Profile</button>
      </form>
    <?php endif ?>
  </section>
  <p> <a href="index.php">Back</a> </p>
</div>

<?php
include_once 'partials/footers.php';
?>
