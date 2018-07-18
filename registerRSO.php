<!DOCTYPE html>
<html lang="en-US">

<?php
  session_set_cookie_params(0);
  session_start();
?>

<html>
  <head>
    <title>EventU - Register RSO</title>
    <link rel="stylesheet" type="text/css" href="css/login.css" />
  </head>

  <body>
    <div class="sidenav">
      <!-- Code for checking if user is logged in or not -->
      <a href="index.php">EventU</a>
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>" . $_SESSION['login_user'] . "</p>"; ?>
        <a href="logout.php">Logout</a>
        <?php if(isset($_SESSION['admin'])): ?>
          <!-- <a href="adminDash.php">Admin Dashboard</a> -->
        <?php endif; ?>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="registerUser.php">Register</a>
      <?php endif; ?>
      <a href="registerRSO.php">Register an RSO</a>
      <a href="joinRSO.php">Join an RSO</a>
    </div>

    <div class="main">
      <h1>EventU - Register RSO</h1>

      <?php
        if(isset($_SESSION['registerRSO_result']))
        {
          // user just joined successfully
          echo '<h4>' . $_SESSION['registerRSO_result'] . '</h4>';
          unset($_SESSION['registerRSO_result']);
        }
      ?>

      <form class="registerRSOForm" action="registerRSOScript.php" method = "post">
        RSO Name:<br />
        <input type="text" name="rsoName" required /><br />
        RSO Description:<br />
        <input type="text" name="rsoDesc" required /><br />
        Member's Emails (You must have at least 4 other registered users):<br />
        <input type="text" name="member1" required /><br />
        <input type="text" name="member2" required /><br />
        <input type="text" name="member3" required /><br />
        <input type="text" name="member4" required /><br />

        <input type="submit" name="submit" value="Submit" /><br />
      </form>
      <p>
        Need to register as a student? <a href="registerUser.php">Register here</a>
      </p>
    </div>
  </body>

</html>
