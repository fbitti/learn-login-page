<?php
include_once 'resource/Database.php';
include_once 'resource/utilities.php';

if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];

  $sqlQuery = "SELECT * FROM users WHERE id = :id";
  $statement = $db->prepare($sqlQuery);
  $statement->execute(array(':id' => $id));

  while ($result = $statement->fetch()) {
    $username = $result['username'];
    $email = $result['email'];
    $date_joined = strftime("%b %d, %Y", strtotime($result['join_date']));
    // %b = abbreviated month, %d = 2 digits of the day, %Y = 4 digits of the year
  }

  $encode_id = base64_encode("encodeuserid{$id}");
}
?>
