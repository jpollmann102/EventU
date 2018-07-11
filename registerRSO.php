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

    <!-- Code to register an RSO -->
    <?php
      require "config.php";
      $error = '';

      if(!isset($_SESSION['studentID']) || !isset($_SESSION['admin']))
      {
        // the person is not a student or admin, they cannot create an RSO
        $error = 'You must be a student or admin to create an RSO';
        exit();
      }

      if(isset($_POST['submit']) && !empty($_POST['rsoName']) && !empty($_POST['member1'])
        && !empty($_POST['member2']) && !empty($_POST['member3']) && !empty($_POST['member4'])
        && !empty($_POST['rsoDesc']))
      {
        $rsoName = htmlspecialchars($_POST['rsoName']);
  			$member1 = htmlspecialchars($_POST['member1']);
        $member2 = htmlspecialchars($_POST['member2']);
        $member3 = htmlspecialchars($_POST['member3']);
        $member4 = htmlspecialchars($_POST['member4']);
        $rsoDesc = htmlspecialchars($_POST['rsoDesc']);

        // // make sure that the user is a student and grab their id
        // $sql = "SELECT student_id FROM student WHERE user_name = '$rsoAdmin'";
        // $result = $conn->query($sql);
        //
        // if($result->num_rows > 0)
        // {
        //   // success
        //   // grab student ID
        //   while($row = $result->fetch_assoc())
        //   {
        //     $studentID = $row['student_id'];
        //   }
        // }else
        // {
        //   // not a registered student
        //   $error = 'You must be a registered student to create an RSO';
        //   $conn->close();
        //   exit();
        // }

        // first make the user an admin
        $adminID = $_SESSION['studentID'] . '_admin';
        $username = $_SESSION['login_username'];
        $sql = "INSERT INTO `the_admin` (`admin_id`, `user_name`)
                VALUES ('$adminID', '$username')";

        if($conn->query($sql))
        {
          // created successfully
          $_SESSION['admin'] = TRUE;
          $_SESSION['login_user'] = $_SESSION['login_user'] . " (" . $rsoName . ")";
        }

        // create the rso
        $loginUsername = $_SESSION['login_username'];
        $loginID = $_SESSION['studentID'];
  			$sql = "INSERT INTO `create_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`, `admin_id`)
  					VALUES ('$rsoName', '$loginUsername', '$loginID', '$rsoDesc', '$adminID')";

  			if($conn->query($sql))
  			{
  				// created successfully


        }else
        {
          // duplicate rso name
          $error = 'RSO name already registered';
          $conn->close();
        }

        // add the new members to join_rso and member_of_rso

      }else
      {
        $error = 'Please enter the information for your RSO';
      }
    ?>

    <form class="registerRSOForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
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
      <h4 class="error"><?php echo $error; ?></h4>
    </form>
    <p>
      Need to register as a student? <a href="registerUser.php">Register here</a>
    </p>
  </body>
</html>
