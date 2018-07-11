<!DOCTYPE html>
<html lang="en-US">
<!-- Code to begin a user session -->
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
    <h1>Login</h1>
    <!-- Code to login a user -->
    <?php
      require "config.php";
      $error = '';
      if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password']))
      {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $sql = "SELECT * FROM the_user WHERE user_name = '$username' AND pass_word = '$password'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
          // success
          // grab first and last name
          while($row = $result->fetch_assoc())
          {
            $firstname = $row['first_name'];
            $lastname = $row['last_name'];
          }
          $_SESSION['logged_in'] = TRUE;
          $_SESSION['login_user'] = $firstname . " " . $lastname;

          // check if the user is a student
          $sql = "SELECT * FROM student WHERE user_name = '$username'";
          $result = $conn->query($sql);
          if($result->num_rows > 0)
          {
            while($row = $result->fetch_assoc())
            {
              $studentID = $row['student_id'];
              $_SESSION['studentID'] = $studentID;
            }
          }

          header("Location: index.php");
          $conn->close();
          exit();
        }else
        {
          // no such account
          $error = 'Incorrect username or password';
        }
      }else
      {
        $error = 'Please enter a username and password';
      }
    ?>

    <form class="login_form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
      Username/Email:<br />
      <input type = "text" name = "username" required /><br />
      Password:<br />
      <input type = "password" name = "password" required /><br />
      <input type = "submit" name = "submit" value = "Submit" />
    </form>
    <p>
      Don't have an account? <a href = "register.php">Register here</a>
    </p>
  </body>
</html>
