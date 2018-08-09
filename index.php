<?php
$page_title = "User Authentication - Homepage";
include_once "partials/headers.php";
?>

  <main role="main" class="container">

    <div class="flag">
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
    </div>

  </main><!-- /.container -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
