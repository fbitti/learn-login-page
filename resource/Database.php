<?php

$db = new PDO('mysql:host=' . $_SERVER['DB_HOST'] .'; dbname=' . $_SERVER['DB_DATABASE'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
echo "Connected to the register database\n";


?>
