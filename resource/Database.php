<?php

// DSN =  Data Source Name
$dsn = 'mysql:host=' . $_SERVER['DB_HOST'] .'; dbname=' . $_SERVER['DB_DATABASE'];
$db_username = $_SERVER['DB_USERNAME'];
$db_password = $_SERVER['DB_PASSWORD'];

try {
  // create an instance of the PDO class with the required parameters
  $db = new PDO($dsn, $db_username, $db_password);

  // set PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // display success message
  echo "Connected to the register database\n";

} catch (PDOException $exception) {
  // display error message
  echo "The database connection failed" . $exception->getMessage() . "\n";
}

?>
