<!DOCTYPE html>
<html lang="en-US">

<?php
  session_set_cookie_params(0);
  session_start();
?>

<html>
  <head>
    <title>EventU</title>
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/vanillaCalendar.css" />
  </head>

  <body>
    <div class="sidenav">
      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>" . $_SESSION['login_user'] . "</p>"; ?>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="registerUser.php">Register</a>
      <?php endif; ?>
      <a href="registerRSO.php">Register an RSO</a>
    </div>

    <div class="main">
      <h1>EventU</h1>

      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>Welcome " . $_SESSION['login_user'] . "</p>"; ?>
      <?php endif; ?>

      <!-- Put calendar here -->


    </div>
  </body>

</html>
