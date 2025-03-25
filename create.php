<?php
session_start();
include_once "./User.php";
include_once "./helper.php"; // Đảm bảo helper.php được gọi

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validate($_POST, ['name', 'email', 'password']);
    if (count($errors) == 0) {
        $dataCreate = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), // Dùng password_hash() thay vì md5()
        ];

        User::create($dataCreate);
        $_SESSION['message'] = "Create success";
        header("location:./index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div>
            <h1>Create User</h1>
        </div>
        <div>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" required>
                    <div class="text-danger">
                        <?php echo $errors['email'] ?? "" ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="exampleInputName" required>
                    <div class="text-danger">
                        <?php echo $errors['name'] ?? "" ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                    <div class="text-danger">
                        <?php echo $errors['password'] ?? "" ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>