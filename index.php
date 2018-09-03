<?php
$page_title = "User Authentication - Homepage";
include_once "partials/headers.php";
?>

<main role="main" class="container">

  <div class="flag text-center">
    <h1>User Authentication System</h1>
    <p class="lead">Mussum Ipsum, cacilds vidis litro abertis. <br> Copo furadis é disculpa de bebadis, arcu quam euismod magna.</p>

    <?php if( !isset($_SESSION['username']) ): ?>
    <p class="lead">You are currently not signed in. <a href="login.php">Login</a>
      <br>
      Not yet a member? <a href="signup.php">Signup</a>
    </p>
    <?php else: ?>
    <p class="lead">You are logged in as <?php if(isset($_SESSION)) echo $_SESSION['username']; ?> <a href="logout.php">Logout</a> </p>
    <?php endif ?>

    <?php echo $_SERVER['REMOTE_ADDR'] . "<br>" .  $_SERVER['HTTP_USER_AGENT'];
        echo "<br>" . time();
        if (isset($_SESSION['last_active'])) {
          echo "<br>" . $_SESSION['last_active'];
        }
    ?>
  </div>

</main><!-- /.container -->

<?php
include_once "partials/footers.php";
?>
