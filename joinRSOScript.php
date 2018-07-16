<?php
  session_set_cookie_params(0);
  session_start();
  require "config.php";

  if(!isset($_SESSION['studentID']))
  {
    $_SESSION['join_result'] = 'You must be a registered student to join an RSO';
    $conn->close();
    header("Location: joinRSO.php");
    exit();
  }

  $rsoName = $_POST["rso_name"];
  $username = $_SESSION['login_username'];
  $studentID = $_SESSION['studentID'];
  $sql = "INSERT INTO `join_rso` (`RSO_name`, `user_name`, `student_id`)
          VALUES ('$rsoName', '$username', 'studentID')";

  if($conn->query($sql))
  {
    // success, joined RSO
    $conn->close();
    $_SESSION['join_result'] = 'Successfully joined ' . $rsoName;
    header("Location: joinRSO.php");
  }else
  {
    $conn->close();
    $_SESSION['join_result'] = 'Error joining RSO';
    header("Location: joinRSO.php");
  }

?>
