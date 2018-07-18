<?php

  session_set_cookie_params(0);
  session_start();

  require "config.php";
  $error = '';

  // Code to register a user
  if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password']))
  {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $uniName = htmlspecialchars($_POST['uni_select']);

    $sql = "INSERT INTO `the_user` (`user_name`, `pass_word`, `first_name`, `last_name`)
            VALUES ('$username', '$password', '$firstname', '$lastname')";

    if($conn->query($sql))
    {
      // created successfully
      $_SESSION['login_username'] = $username;
      $_SESSION['login_user'] = $firstname . " " . $lastname;
      $_SESSION['logged_in'] = TRUE;
    }else
    {
      // duplicate username
      $_SESSION['register_result'] = 'Username taken';
      header("Location: registerUser.php");
      $conn->close();
      exit();
    }

    $sql = "INSERT INTO `user_university` (`user_name`, `university_name`)
            VALUES ('$username', '$uniName')";

    if($conn->query($sql))
    {
      // created successfully
      $_SESSION['user_uni'] = $uniName;
    }else
    {
      // duplicate username
      $_SESSION['register_result'] = 'Error with registering in university';
      header("Location: registerUser.php");
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
        $_SESSION['register_result'] = 'Some error adding student';
        header("Location: registerUser.php");
        $conn->close();
        exit();
      }

      $conn->close();
      header("Location: index.php");
    }
  }else
  {
    $_SESSION['register_result'] = 'Please enter the information above';
  }
?>
