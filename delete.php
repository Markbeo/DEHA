<?php
session_start();
include_once './User.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $deleted = User::destroy($id); // Kiểm tra số hàng bị ảnh hưởng

    if ($deleted) {
        $_SESSION['message'] = "Xóa thành công!";
    } else {
        $_SESSION['message'] = "Không tìm thấy user hoặc xóa thất bại!";
    }
} else {
    $_SESSION['message'] = "Yêu cầu không hợp lệ!";
}

header("Location: index.php");
exit();
