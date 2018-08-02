<?php

// revealing username and password now during a testing phase. Moving to $_ENV variables in the future
$db = new PDO('mysql:host=localhost; dbname=register', 'root', 'abc123');

echo "Connected to the register database";
