<?php
include_once "resource/session.php";
session_destroy();
redirectTo("index");
?>
