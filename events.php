<?php


$connect = new PDO('mysql:host=localhost;dbname=eventwebsite', 'root', 'root');

$data = array();

$query = "SELECT * FROM can_create_school_event ORDER BY event_id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

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
