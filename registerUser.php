<!DOCTYPE html>
<html lang="en-US">

<?php
  session_set_cookie_params(0);
  session_start();
?>

<html>
  <head>
    <title>EventU - Register</title>
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
      <?php if(isset($_SESSION['logged_in'])): ?>
      <a href="registerRSO.php">Register an RSO</a>
      <a href="joinRSO.php">Join an RSO</a>
      <?php endif; ?>
    </div>


    <div class="main">
      <h1>EventU - Register</h1>

      <form class="registerUserForm" action="registerUserScript.php" method = "post">
        First Name:<br />
        <input type="text" name="firstname" required /><br />
        Last Name:<br />
        <input type="text" name="lastname" required /><br />
        Email:<br />
        <input type="text" name="username" required /><br />
        Password:<br />
        <input type="password" name="password" required /><br />
        <input type="checkbox" id="studentCheck" name="student" onclick="studentChecked()"/> Are you a student?<br />
        University:<br />

        <select name="uni_select">

          <?php
            require "config.php";
            $error = '';
            $sql = "SELECT DISTINCT university_name FROM part_of_university ORDER BY university_name ASC";
            $result = $conn->query($sql);

            if($result->num_rows > 0)
            {
              while($row = $result->fetch_assoc())
              {
                echo "<option>" . $row["university_name"] . "</option>";
              }
            }else
            {
              $error = 'University spinner broken';
            }
          ?>

        </select><br />
        <input type="submit" name="submit" value="Submit" /><br />

        <?php
          if(isset($_SESSION['register_result']))
          {
            // user just joined successfully
            echo '<h4>' . $_SESSION['register_result'] . '</h4>';
            unset($_SESSION['register_result']);
          }
        ?>

      </form>
      <p>
        <?php echo $error; ?>
      </p>
      <p>
        Already have an account? <a href="login.php">Login here</a><br /><br />
        Looking to register an RSO? <a href="registerRSO.php">Register here</a>
      </p>
    </div>
  </body>
</html>
