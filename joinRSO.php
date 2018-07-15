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
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="registerUser.php">Register</a>
      <?php endif; ?>
      <a href="registerRSO.php">Register an RSO</a>
      <a href="joinRSO.php">Join an RSO</a>
    </div>

    <div class="main">
      <p>test1</p>
      <?php
        if(isset($_SESSION['join_result']))
        {
          // user just joined successfully
          echo '<h4>' . $_SESSION['join_result'] . '</h4>';
          unset($_SESSION['join_result']);
        }
      ?>
      <p>test2</p>
      <?php

        $error = '';
        // check if the user is a student
        if(!isset($_SESSION['studentID']))
        {
          // not a student, can't join an RSO
          $error = 'You must be a student to join an RSO';
          exit();
        }

        require "config.php";

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
            echo "<td><input type='hidden' name='rso_name' value=" . $rsoName . " />" . $rsoName . "</td>";
            echo "<td><form action='joinRSOScript.php' method='post'><input type='submit' value='Join'/></form></td>";
            echo "</tr>";
          }

          echo "</table>";
        }else
        {
          $error = 'Error retrieving RSO names';
        }
        $conn->close();
      ?>
      <p>test3</p>
      <h4 class="error"><?php echo $error; ?></h4>
    </div>
  </body>

</html>
