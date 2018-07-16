<?php

require "config.php";

  session_set_cookie_params(0);
  session_start();
$adid = $_SESSION['adm_id'];
$usnm = $_SESSION['login_username'];
$sch = $_SESSION['school'];

$query = "INSERT INTO can_create_school_event (`event_name`, `start_date`, `end_date`, `category`, `location`, `phone_num`, `event_type`, `email`, `admin_id`, `user_name`, `event_description`, `event_id`, `RSO_name`)
                VALUE('{$_POST['eventnm']}', '{$_POST['eventstart']}', '{$_POST['eventend']}', '{$_POST['eventcat']}', '{$_POST['eventloc']}', '{$_POST['eventnum']}', '{$_POST['eventtyp']}', '{$_POST['eventmail']}', '$adid', '$usnm', '{$_POST['eventdesc']}', DEFAULT, '{$_POST['eventrso']}')";

}

$result = $conn->query($query);

echo "Error: " . $query . "<br>" . $conn->error;

/*$query = "INSERT INTO university_hosts (`university_name`, `event_name`, `event_id`)
                VALUE('$sch', '{$_POST['eventnm']}', DEFAULT)";

}

$result = $conn->query($query);

echo json_encode($data);*/

?>
