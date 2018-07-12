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
      $conn->beginTransaction();

      // check if the user can create an RSO
      if(!isset($_SESSION['studentID']) || !isset($_SESSION['admin']))
      {
        // the person is not a student or admin, they cannot create an RSO
        $error = 'You must be a student or admin to create an RSO';
        $conn->close();
        exit();
      }

      // check if RSO name is already registered
      if(!empty($_POST['rsoName']))
      {
        $rsoName = htmlspecialchars($_POST['rsoName']);
        $sql = "SELECT RSO_name FROM create_rso WHERE RSO_name = '$rsoName'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
          // error, RSO already created
          $error = 'RSO name taken';
          $conn->close();
          exit();
        }
      }else
      {
        $error = 'Please enter a name for your RSO';
        $conn->close();
        exit();
      }

      if(isset($_POST['submit']) && !empty($_POST['member1'])
        && !empty($_POST['member2']) && !empty($_POST['member3']) && !empty($_POST['member4'])
        && !empty($_POST['rsoDesc']))
      {
  			$member1 = htmlspecialchars($_POST['member1']);
        $member2 = htmlspecialchars($_POST['member2']);
        $member3 = htmlspecialchars($_POST['member3']);
        $member4 = htmlspecialchars($_POST['member4']);
        $rsoDesc = htmlspecialchars($_POST['rsoDesc']);

        /**** first, make sure they are all registered students ****/
        $sql = "SELECT * FROM students WHERE user_name = '$member1'";
        $result = $conn->query($sql);

        if(!$result->num_rows > 0)
        {
          // not a registered user
          $error = 'Member 1 is not a registered student';
          $conn->close();
          exit();
        }

        $sql = "SELECT * FROM students WHERE user_name = '$member2'";
        $result = $conn->query($sql);

        if(!$result->num_rows > 0)
        {
          // not a registered user
          $error = 'Member 2 is not a registered student';
          $conn->close();
          exit();
        }

        $sql = "SELECT * FROM students WHERE user_name = '$member3'";
        $result = $conn->query($sql);

        if(!$result->num_rows > 0)
        {
          // not a registered user
          $error = 'Member 3 is not a registered student';
          $conn->close();
          exit();
        }

        $sql = "SELECT * FROM students WHERE user_name = '$member4'";
        $result = $conn->query($sql);

        if(!$result->num_rows > 0)
        {
          // not a registered user
          $error = 'Member 4 is not a registered student';
          $conn->close();
          exit();
        }
        /*************************************************************/

        /**** then make the user an admin ****/
        $adminID = $_SESSION['studentID'] . '_admin';
        $username = $_SESSION['login_username'];
        $sql = "INSERT INTO `the_admin` (`admin_id`, `user_name`)
                VALUES ('$adminID', '$username')";

        if(!$conn->query($sql))
        {
          // some error making them an admin
          $error = 'Some error making user an admin';
          $conn->close();
          exit();
        }
        /*************************************************************/

        /**** create the rso ****/
        $loginUsername = $_SESSION['login_username'];
        $loginID = $_SESSION['studentID'];
  			$sql = "INSERT INTO `create_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`, `admin_id`)
  					VALUES ('$rsoName', '$loginUsername', '$loginID', '$rsoDesc', '$adminID')";

  			if(!$conn->query($sql))
  			{
          // some error creating RSO
          $error = 'Some error inserting RSO';

          // // remove user as an admin
          // $sql = "DELETE FROM `the_admin` WHERE `user_name` = '$username'";
          //
          // if(!$conn->query($sql))
          // {
          //   // error removing user as an admin
          //   $error = $error . 'Error removing admin';
          // }

          $conn->rollback();
          $conn->close();
          exit();
        }
        /*************************************************************/

        /**** add the new members to join_rso and member_of_rso ****/
        // first, get the student id of each new member
        $sql = "SELECT student_id FROM student WHERE user_name = '$member1'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
          while($row = $result->fetch_assoc())
          {
            $member1ID = $row['student_id'];
          }
        }else
        {
          // some error getting the student id
          $error = 'Error getting student id of member 1';

          // // remove user as admin and delete RSO
          // $sql = "DELETE FROM `the_admin` WHERE `user_name` = '$username'";
          //
          // if(!$conn->query($sql))
          // {
          //   // error removing user as an admin
          //   $error = $error . ' Error removing user as admin';
          // }
          //
          // $sql = "DELETE FROM `create_rso` WHERE `RSO_name` = '$rsoName'";
          // if(!$conn->query($sql))
          // {
          //   // error removing user as an admin
          //   $error = $error . 'Error removing RSO';
          // }

          $conn->rollback();
          $conn->close();
          exit();
        }

        $sql = "SELECT student_id FROM student WHERE user_name = '$member2'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
          while($row = $result->fetch_assoc())
          {
            $member2ID = $row['student_id'];
          }
        }else
        {
          // some error getting the student id
          $error = 'Error getting student id of member 2';

          // // remove user as admin and delete RSO
          // $sql = "DELETE FROM `the_admin` WHERE `user_name` = '$username'";
          //
          // if(!$conn->query($sql))
          // {
          //   // error removing user as an admin
          //   $error = $error . ' Error removing user as admin';
          // }
          //
          // $sql = "DELETE FROM `create_rso` WHERE `RSO_name` = '$rsoName'";
          // if(!$conn->query($sql))
          // {
          //   // error removing user as an admin
          //   $error = $error . 'Error removing RSO';
          // }

          $conn->rollback();
          $conn->close();
          exit();
        }

        $sql = "SELECT student_id FROM student WHERE user_name = '$member3'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
          while($row = $result->fetch_assoc())
          {
            $member3ID = $row['student_id'];
          }
        }else
        {
          // some error getting the student id
          $error = 'Error getting student id of member 3';

          // // remove user as admin and delete RSO
          // $sql = "DELETE FROM `the_admin` WHERE `user_name` = '$username'";
          //
          // if(!$conn->query($sql))
          // {
          //   // error removing user as an admin
          //   $error = $error . ' Error removing user as admin';
          // }
          //
          // $sql = "DELETE FROM `create_rso` WHERE `RSO_name` = '$rsoName'";
          // if(!$conn->query($sql))
          // {
          //   // error removing user as an admin
          //   $error = $error . 'Error removing RSO';
          // }

          $conn->rollback();
          $conn->close();
          exit();
        }

        $sql = "SELECT student_id FROM student WHERE user_name = '$member4'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
          while($row = $result->fetch_assoc())
          {
            $member4ID = $row['student_id'];
          }
        }else
        {
          // some error getting the student id
          $error = 'Error getting student id of member 1';

          // // remove user as admin and delete RSO
          // $sql = "DELETE FROM `the_admin` WHERE `user_name` = '$username'";
          //
          // if(!$conn->query($sql))
          // {
          //   // error removing user as an admin
          //   $error = $error . ' Error removing user as admin';
          // }
          //
          // $sql = "DELETE FROM `create_rso` WHERE `RSO_name` = '$rsoName'";
          // if(!$conn->query($sql))
          // {
          //   // error removing user as an admin
          //   $error = $error . 'Error removing RSO';
          // }

          $conn->rollback();
          $conn->close();
          exit();
        }

        /**** add members to join_rso ****/
        $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
                VALUES ('$rsoName', '$username', '$loginID', '$rsoDesc')";

        if(!$conn->query($sql))
  			{
          // some error inserting creator
          $error = 'Error inserting creator into join_rso';
        }

        $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
                VALUES ('$rsoName', '$member1', '$member1ID', '$rsoDesc')";

        if(!$conn->query($sql))
  			{
          // some error inserting member1
          $error = $error . ' Error inserting member 1 into join_rso';
        }

        $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
                VALUES ('$rsoName', '$member2', '$member2ID', '$rsoDesc')";

        if(!$conn->query($sql))
  			{
          // some error inserting member2
          $error = $error . ' Error inserting member 2 into join_rso';
        }

        $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
                VALUES ('$rsoName', '$username', '$loginID', '$rsoDesc')";

        if(!$conn->query($sql))
  			{
          // some error inserting member3
          $error = $error . ' Error inserting member 3 into join_rso';
        }

        $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
                VALUES ('$rsoName', '$member4', '$member4ID', '$rsoDesc')";

        if(!$conn->query($sql))
  			{
  				// some error inserting member4
          $error = $error . ' Error inserting member 4 into join_rso';
        }

        if($error != '')
        {
          // an error occurred, delete anything that may have been added
          $conn->rollback();
          $conn->close();
          exit();
        }
        /*************************************************************/

        /**** add admin to member_of_rso ****/
        $sql = "INSERT INTO `member_of_rso` (`RSO_name`, `admin_id`, `user_name`, `student_id`)
                VALUES ('$rsoName', '$adminID', '$loginUsername', '$loginID')";

        if(!$conn->query($sql))
        {
          // some error inserting admin
          $error = 'Error inserting admin into member_of_rso';
          $conn->rollback();
          $conn->close();
          exit();
        }
        /*************************************************************/

        // created successfully
        $_SESSION['admin'] = TRUE;
        $_SESSION['login_user'] = $_SESSION['login_user'] . " (" . $rsoName . ")";
        $conn->commit();
        header("Location: index.php");
        $conn->close();
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
