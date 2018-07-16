<?php

  session_set_cookie_params(0);
  session_start();

  // check if the user can create an RSO
  if(!isset($_SESSION['studentID']) && !isset($_SESSION['admin']))
  {
    // the person is not a student or admin, they cannot create an RSO
    $_SESSION['registerRSO_result'] = 'You must be a student or admin to create an RSO';
    header("Location: registerRSO.php");
    exit();
  }

  require "config.php";

  // check if RSO name is already registered
  if(!empty($_POST['rsoName']))
  {
    $rsoName = htmlspecialchars($_POST['rsoName']);
    $sql = "SELECT RSO_name FROM member_of_rso WHERE RSO_name = '$rsoName'";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
      // error, RSO already created
      $_SESSION['registerRSO_result'] = 'RSO name taken';
      header("Location: registerRSO.php");
      $conn->close();
      exit();
    }
  }else
  {
    $_SESSION['registerRSO_result'] = 'Please enter a name for your RSO';
    header("Location: registerRSO.php");
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
    $loginUsername = $_SESSION['login_username'];
    $loginID = $_SESSION['studentID'];

    /**** first, make sure they are all registered students ****/
    $sql = "SELECT * FROM student WHERE user_name = '$member1'";
    $result = $conn->query($sql);

    if(!$result->num_rows > 0)
    {
      // not a registered user
      $_SESSION['registerRSO_result'] = 'Member 1 is not a registered student';
      header("Location: registerRSO.php");
      $conn->close();
      exit();
    }

    $sql = "SELECT * FROM student WHERE user_name = '$member2'";
    $result = $conn->query($sql);

    if(!$result->num_rows > 0)
    {
      // not a registered user
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Member 2 is not a registered student';
      header("Location: registerRSO.php");
      $conn->close();
      exit();
    }

    $sql = "SELECT * FROM student WHERE user_name = '$member3'";
    $result = $conn->query($sql);

    if(!$result->num_rows > 0)
    {
      // not a registered user
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Member 3 is not a registered student';
      header("Location: registerRSO.php");
      $conn->close();
      exit();
    }

    $sql = "SELECT * FROM student WHERE user_name = '$member4'";
    $result = $conn->query($sql);

    if(!$result->num_rows > 0)
    {
      // not a registered user
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Member 4 is not a registered student';
      header("Location: registerRSO.php");
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
      $_SESSION['registerRSO_result'] = 'Some error making user an admin';
      header("Location: registerRSO.php");
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
      $_SESSION['registerRSO_result'] = 'Error getting student id of member 1';
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
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Error getting student id of member 2';
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
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Error getting student id of member 3';
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
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Error getting student id of member 4';
    }

    if($_SESSION['registerRSO_result'] != '')
    {
      // an error occured

      $sql = "DELETE FROM `the_admin` WHERE `user_name` = '$username'";

      if(!$conn->query($sql))
      {
        // error removing user as an admin
        $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Error removing user as admin';
      }

      $conn->close();
      header("Location: registerRSO.php");
      exit();
    }

    /**** add members to join_rso ****/
    $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
            VALUES ('$rsoName', '$username', '$loginID', '$rsoDesc')";

    if(!$conn->query($sql))
    {
      // some error inserting creator
      $_SESSION['registerRSO_result'] = 'Error inserting creator into join_rso';
    }

    $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
            VALUES ('$rsoName', '$member1', '$member1ID', '$rsoDesc')";

    if(!$conn->query($sql))
    {
      // some error inserting member1
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Error inserting member 1 into join_rso';
    }

    $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
            VALUES ('$rsoName', '$member2', '$member2ID', '$rsoDesc')";

    if(!$conn->query($sql))
    {
      // some error inserting member2
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Error inserting member 2 into join_rso';
    }

    $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
            VALUES ('$rsoName', '$member3', '$loginID', '$rsoDesc')";

    if(!$conn->query($sql))
    {
      // some error inserting member3
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Error inserting member 3 into join_rso';
    }

    $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`, `RSO_description`)
            VALUES ('$rsoName', '$member4', '$member4ID', '$rsoDesc')";

    if(!$conn->query($sql))
    {
      // some error inserting member4
      $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . ' Error inserting member 4 into join_rso';
    }

    if($_SESSION['registerRSO_result'] != '')
    {
      // an error occurred, delete anything that may have been added
      $sql = "DELETE FROM `join_rso` WHERE `RSO_name` = '$rsoName'";
      if(!$conn->query($sql))
      {
        // error removing user as an admin
        $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . 'Error removing users from join_rso';
      }

      $conn->close();
      header("Location: registerRSO.php");
      exit();
    }
    /*************************************************************/

    /**** add admin to member_of_rso ****/
    $sql = "INSERT INTO `member_of_rso` (`RSO_name`, `admin_id`, `user_name`, `student_id`)
            VALUES ('$rsoName', '$adminID', '$loginUsername', '$loginID')";

    if(!$conn->query($sql))
    {
      // some error inserting admin
      $_SESSION['registerRSO_result'] = 'Error inserting admin into member_of_rso';

      // remove everything we just added
      $sql = "DELETE FROM `join_rso` WHERE `RSO_name` = '$rsoName'";
      if(!$conn->query($sql))
      {
        // error removing user as an admin
        $_SESSION['registerRSO_result'] = $_SESSION['registerRSO_result'] . 'Error removing users from join_rso';
      }

      $conn->close();
      header("Location: registerRSO.php");
      exit();
    }
    /*************************************************************/

    // created successfully
    $_SESSION['admin'] = TRUE;
    $_SESSION['adminRSO'] = $rsoName;
    $_SESSION['login_user'] = $_SESSION['login_user'] . " (" . $rsoName . ")";
    header("Location: registerRSO.php");
    $conn->close();
  }else
  {
    $_SESSION['registerRSO_result'] = 'Please enter the information for your RSO';
  }
?>
