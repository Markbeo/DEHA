<?php
include_once "./User.php";
User::logout();
header("Location: login.php");
exit();
