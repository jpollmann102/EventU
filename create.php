<?php

require "config.php";

  session_set_cookie_params(0);
  session_start();
$adid = $_SESSION['adm_id'];
$usnm = $_SESSION['login_username'];
$sch = $_SESSION['school'];
$ename = $_POST['eventnm'];
$estart = $_POST['eventstart'];
$eend = $_POST['eventend'];
$ecat = $_POST['eventcat'];
$eloc = $_POST['eventloc'];
$enum = $_POST['eventnum'];
$etype = $_POST['eventtyp'];
$eemail = $_POST['eventmail'];
$edesc = $_POST['eventdesc'];
$erso = $_POST['eventrso'];

$query = 'INSERT INTO `can_create_school_event` (`event_name`, `start_date`, `end_date`, `category`, `location`, `phone_num`, `event_type`, `email`, `admin_id`, `user_name`, `event_description`, `event_id`, `RSO_name`)
                VALUES('$ename', '$estart', '$eend', '$ecat', '$eloc', '$enum', '$etype', '$eemail', '$adid', '$usnm', '$edesc', DEFAULT, '$erso')';


$result = $conn->query($query);

echo "Error: " . $query . "<br>" . $conn->error;

/*$query = "INSERT INTO university_hosts (`university_name`, `event_name`, `event_id`)
                VALUE('$sch', '{$_POST['eventnm']}', DEFAULT)";

}

$result = $conn->query($query);

echo json_encode($data);*/

?>
