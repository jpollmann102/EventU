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
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="registerUser.php">Register</a>
      <?php endif; ?>
      <a href="registerRSO.php">Register an RSO</a>
      <a href="joinRSO.php">Join an RSO</a>
    </div>

    <!-- Code to register a user -->
    <?php
      require "config.php";
      $error = '';

      if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password']))
      {
        $username = htmlspecialchars($_POST['username']);
  			$password = htmlspecialchars($_POST['password']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);

  			$sql = "INSERT INTO `the_user` (`user_name`, `pass_word`, `first_name`, `last_name`)
  					VALUES ('$username', '$password', '$firstname', '$lastname')";

  			if($conn->query($sql))
  			{
  				// created successfully
          $_SESSION['admin'] = FALSE;
          $_SESSION['login_username'] = $username;
  				$_SESSION['login_user'] = $firstname . " " . $lastname;
  				$_SESSION['logged_in'] = TRUE;
        }else
        {
          // duplicate username
          $error = 'Username taken';
          $conn->close();
          exit();
        }

        if(isset($_POST['student']))
        {
          // user is a student
          $randID = rand(1000, 9999);
          $studentID = $firstname[0] . $lastname[0] . $randID;

          $sql = "INSERT INTO `student` (`student_id`, `user_name`)
                  VALUES ('$studentID', '$username')";

          if($conn->query($sql))
          {
            // added to student db successfully
            $_SESSION['studentID'] = $studentID;
          }else
          {
            $error = 'Some error adding student';
            $conn->close();
            exit();
          }

          $conn->close();
          header("Location: index.php");
        }
      }else
      {
        $error = 'Please enter the information above';
      }
    ?>

    <div class="main">
      <h1>EventU - Register</h1>

      <form class="registerUserForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
        First Name:<br />
        <input type="text" name="firstname" required /><br />
        Last Name:<br />
        <input type="text" name="lastname" required /><br />
        Username:<br />
        <input type="text" name="username" required /><br />
        Password:<br />
        <input type="password" name="password" required /><br />
        <input type="checkbox" id="studentCheck" name="student" onclick="studentChecked()"/> Are you a student?<br />

        <input type="submit" name="submit" value="Submit" /><br />
        <h4 class="error"><?php echo $error; ?></h4>
      </form>
      <p>
        Already have an account? <a href="login.php">Login here</a><br /><br />
        Looking to register an RSO? <a href="registerRSO.php">Register here</a>
      </p>
    </div>
  </body>
</html>
