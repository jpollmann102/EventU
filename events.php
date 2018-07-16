<?php

require "config.php";

  session_set_cookie_params(0);
  session_start();

$data = array();

$query = "SELECT * FROM can_create_school_event WHERE event_id IN (SELECT event_id FROM university_hosts WHERE university_name = '{$_POST['uni']}')";

$result = $conn->query($query);

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["event_id"],
  'title'   => $row["event_name"],
  'start'   => $row["start_date"],
  'end'   => $row["end_date"],
  'category'    => $row["category"],
  'location'    => $row["location"],
  'phone'   => $row["phone_num"],
  'type'    => $row["event_type"],
  'email'   => $row["email"],
  'admin_id'    => $row["admin_id"],
  'description' => $row["event_description"]
 );
}

echo json_encode($data);

?>
