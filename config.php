<?php

// Connecting to the MySQL database
$user = 'gergela1';
$password = 'af8qLftX';

$database = new PDO('mysql:host=csweb.hh.nku.edu;dbname=db_spring17_gergela1', $user, $password);

// Start the session

$current_url = basename($_SERVER['REQUEST_URI']);

function my_autoloader($class){
    include 'class.' . $class . '.php';
}

spl_autoload_register('my_autoloader');

session_start();


if (!isset($_SESSION["userID"]) && $current_url != 'login.php') {
    header("Location: login.php");
}

elseif (isset($_SESSION["userID"])) {
    $customer = new Customer($_SESSION["userID"],$database);
}