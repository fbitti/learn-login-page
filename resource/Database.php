<?php

// DSN =  Data Source Name
$dsn = 'mysql:host=' . $_SERVER['DB_HOST'] .'; dbname=' . $_SERVER['DB_DATABASE'];
$db_username = $_SERVER['DB_USERNAME'];
$db_password = $_SERVER['DB_PASSWORD'];

try {
  $db = new PDO($dsn, $db_username, $db_password);
  echo "Connected to the register database\n";
} catch (PDOException $exception) {
  echo "The database connection failed" . $exception->getMessage() . "\n";
}

?>
