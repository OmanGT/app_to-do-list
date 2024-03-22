<?php

$host = 'localhost';
$user = 'root';
$pass = 'root';
$db_name = 'db_app-to-do-list';

$connect = mysqli_connect($host, $user, $pass, $db_name) or die(mysqli_error($connect));
