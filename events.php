<?php


$connect = new PDO('mysql:host=localhost;dbname=eventwebsite', 'root', 'root');

$data = array();

$query = "SELECT * FROM can_create_school_event ORDER BY event_name";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["event_name"],
  'title'   => $row["event_name"],
  'start'   => $row["event_date"],
  //'end'   => $row["end_event"]
 );
}

echo json_encode($data);

?>
