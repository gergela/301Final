<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/23/17
 * Time: 12:46 AM
 */

include('config.php');

session_destroy();

header('location: login.php');