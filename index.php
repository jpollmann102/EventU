<!DOCTYPE html>
<html lang="en-US">

<html>
  <head>
    <title>EventU</title>
    <link rel="stylesheet" type="text/css" href="css/index.css" />
  </head>

  <body>
    <div class="sidenav">
      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>" . $_SESSION['login_user'] . "</p>" ?>
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
        <?php echo "<p>Welcome " . $_SESSION['login_user'] . "</p>" ?>
      <?php endif; ?>

      <!-- Put calendar here -->

    </div>
  </body>

</html>
