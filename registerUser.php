<!DOCTYPE html>
<html lang="en-US">

<?php
  session_set_cookie_params(0);
  session_start();
?>

<html>
  <head>
    <title>EventU</title>
    <!-- TODO: put in stylesheets -->
  </head>

  <body>
    <h1><a href="index.php">EventU</a></h1>
    <h1>Register</h1>

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
          $_SESSION['isRSO'] = FALSE;
  				$_SESSION['login_user'] = $firstname . " " . $lastname;
  				$_SESSION['logged_in'] = TRUE;
        }else
        {
          // duplicate username
          $error = 'Username taken';
          $conn->close();
        }

        if(isset($_POST['student']))
        {
          // user is a student
          if(!empty($_POST['studentID']))
          {
            $studentID = htmlspecialchars($_POST['studentID']);

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
            }
          }else
          {
            $error = 'Please enter your student ID if you are a student';
          }
        }
      }else
      {
        $error = 'Please enter a username and password';
      }
    ?>

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
      <p id="studentChecked" style="display:none">
        Student ID:<br />
      </p>
      <input id="studentChecked" name="studentID" style="display:none" type="text" required />

      <script>
        function studentChecked()
        {
          var checkBox = document.getElementById("studentCheck");
          var textToAdd = document.getElementById("studentChecked");
          if(checkBox.checked) textToAdd.style.display = "block";
          else textToAdd.style.display = "none";
        }
      </script>

      <input type="submit" name="submit" value="Submit" /><br />
      <h4 class="error"><?php echo $error; ?></h4>
    </form>
    <p>
      Already have an account? <a href="login.php">Login here</a>
      Looking to register an RSO? <a href="registerRSO.php">Register here</a>
    </p>
  </body>
</html>
