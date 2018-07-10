<!DOCTYPE html>
<html lang="en-US">

<html>
  <head>
    <title>EventU</title>
    <!-- TODO: put in stylesheets -->
  </head>

  <body>
    <h1>EventU</h1>

    <!-- Code for checking if user is logged in or not -->
    <?php if(isset($_SESSION['logged_in'])): ?>
      <?php echo "<p>" . $_SESSION['login_user'] . "</p>" ?>
      <a href="logout.php"><p>Logout</p></a>
    <?php else: ?>
      <a href="login.php"><h3>Login</h3></a>
      <a href="registerUser.php"><h3>Register</h3></a>
      <a href="registerRSO.php"><h3>Register and RSO</h3></a>
    <?php endif; ?>

    <!-- Put calendar here -->


  </body>

</html>
