<!DOCTYPE html>
<html lang="en-US">
<!-- Code to begin a user session -->
<?php
  session_set_cookie_params(0);
  session_start();
?>

<html>
  <head>
    <title>EventU - Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css" />
  </head>

  <body>
    <div class="sidenav">

      <!-- Code for checking if user is logged in or not -->
      <a href="index.php">EventU</a>
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>" . $_SESSION['login_user'] . "</p>" ?>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="registerUser.php">Register</a>
      <?php endif; ?>
      <?php if(isset($_SESSION['logged_in'])): ?>
      <a href="registerRSO.php">Register an RSO</a>
      <a href="joinRSO.php">Join an RSO</a>
<?php endif; ?>

    </div>

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
          $_SESSION['login_username'] = $username;
          $_SESSION['login_user'] = $firstname . " " . $lastname;

          // check if the user is a student
          $sql = "SELECT * FROM student WHERE user_name = '$username'";
          $result = $conn->query($sql);
          if($result->num_rows > 0)
          {
            // user is in fact a student
            while($row = $result->fetch_assoc())
            {
              $studentID = $row['student_id'];
              $_SESSION['studentID'] = $studentID;
            }
          }

          // check if the user is an admin as well
          $sql = "SELECT RSO_name FROM member_of_rso WHERE user_name = '$username'";
          $result = $conn->query($sql);
          if($result->num_rows > 0)
          {
            // user is in fact an admin
            $_SESSION['admin'] = TRUE;
            while($row = $result->fetch_assoc())
            {
              $_SESSION['adminRSO'] = $row['RSO_name'];
              $_SESSION['login_user'] = $_SESSION['login_user'] . " (" . $_SESSION['adminRSO'] . ")";
            }
          }
          if($_SESSION['admin']){
          $sql = "SELECT admin_id FROM the_admin WHERE user_name = '$username'";
          $result = $conn->query($sql);
          if($result->num_rows > 0)
          {
            // user is in fact an admin
            while($row = $result->fetch_assoc())
            {
              $_SESSION['adm_id'] = $row['admin_id'];
            }
          }
        }

           // check enrolled university
           $sql = "SELECT university_name FROM user_university WHERE user_name = '$username'";
           $result = $conn->query($sql);
           if($result->num_rows > 0)
           {
             // user is in fact an admin
             while($row = $result->fetch_assoc())
            {
              $_SESSION['school'] = $row['university_name'];
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

    <div class="main">
      <h1>EventU - Login</h1>
      <form class="login_form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        Email:<br />
        <input type = "text" name = "username" required /><br />
        Password:<br />
        <input type = "password" name = "password" required /><br />
        <input type = "submit" name = "submit" value = "Submit" />
      </form>
      <p>
        Don't have an account? <a href = "registerUser.php">Register here</a>
      </p>
    </div>

  </body>
</html>
