<!DOCTYPE html>
<html lang="en-US">

<?php
  session_set_cookie_params(0);
  session_start();
?>

<html>

  <head>
    <title>EventU - Join RSO</title>
    <link rel="stylesheet" type="text/css" href="css/joinRSO.css" />
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
      <h2>Browse RSO's</h2>

      <?php
        if(isset($_SESSION['join_result']))
        {
          // user just joined successfully
          echo '<h4>' . $_SESSION['join_result'] . '</h4>';
          unset($_SESSION['join_result']);
        }
      ?>

      <br /><br />
      <?php

        require "config.php";
        $error = '';

        $sql = "SELECT RSO_name FROM member_of_rso";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
          // success
          echo "<table class='table'>";

          while($row = $result->fetch_assoc())
          {
            $rsoName = $row['RSO_name'];
            echo "<tr>";
            //echo "<td><input type='hidden' name='rso_name' value=" . $rsoName . " />" . $rsoName . "</td>";
            echo "<td><form action='joinRSOScript.php' method='post'>
            <input type='hidden' name='rso_name' value=" . $rsoName . " />" . $rsoName . "</td>
            <td><input type='submit' value='Join'/></form></td>";
            echo "</tr>";
          }

          echo "</table>";
        }else
        {
          $error = 'Error retrieving RSO names';
        }
        $conn->close();

      ?>

      <h4 class="error"><?php echo $error; ?></h4>
    </div>
  </body>

</html>
