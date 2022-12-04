<?php

$host = "localhost";
$user = "root";
$pass = "";
$db_name = "php-todo-app";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $err) {
    echo "Connection failed 😕: " . $err->getMessage();
}
