<?php
include_once "./User.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    User::register($_POST['name'], $_POST['email'], $_POST['password']);
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng ký</title>
</head>

<body>
    <form method="post">
        <h2>Đăng ký</h2>
        <input type="text" name="name" placeholder="Tên" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mật khẩu" required><br>
        <button type="submit">Đăng ký</button>
    </form>
</body>

</html>