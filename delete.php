<?php
session_start(); // Cần khởi động session
include_once './User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    User::destroy($id);

    $_SESSION['message'] = "Delete success";
    header("Location: index.php"); // Chuyển hướng về trang danh sách
    exit();
} else {
    $_SESSION['message'] = "User not found";
    header("Location: index.php");
    exit();
}
