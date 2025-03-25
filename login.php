<?php
session_start();
include_once "./User.php";

$error = "";

// Kiểm tra nếu đã đăng nhập thì chuyển hướng về trang index
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? "";
    $password = $_POST['password'] ?? "";

    // Kiểm tra nếu người dùng nhập đủ thông tin
    if (!empty($name) && !empty($password)) {
        if (User::login($name, $password)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Tên hoặc mật khẩu không đúng!";
        }
    } else {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>

<body>
    <form method="post">
        <h2>Đăng nhập</h2>

        <?php if (!empty($error)) { ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php } ?>

        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" placeholder="Nhập tên" required><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" required><br>

        <button type="submit">Đăng nhập</button>
    </form>
</body>

</html>