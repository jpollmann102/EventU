<!DOCTYPE html>
<html lang="en-US">

<?php
  session_set_cookie_params(0);
  session_start();

  if(!isset($_SESSION['admin']) || !isset($_SESSION['logged_in']))
  {
    // somehow got here as not an admin, revert
    header("Location: index.php");
    exit();
  }
?>

<html>

  <head>
    <title>EventU - Join RSO</title>
    <link rel="stylesheet" type="text/css" href="css/adminDash.css" />
  </head>

  <body>
    <div class="sidenav">
      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>" . $_SESSION['login_user'] . "</p>"; ?>
        <a href="logout.php">Logout</a>
        <?php if(isset($_SESSION['admin'])): ?>
          <a href="adminDash.php">Admin Dashboard</a>
        <?php endif; ?>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="registerUser.php">Register</a>
      <?php endif; ?>
      <a href="registerRSO.php">Register an RSO</a>
      <a href="joinRSO.php">Join an RSO</a>
    </div>

    <div class="main">
      


    </div>

  </body>


</html>
