<?php
include_once "./User.php";
$id = null;
$user = null;
if ($_GET['id']) {
    $id = $_GET['id'];
    $user = User::find($id);
} else {
    header("location:./index.php");
}


$errors = [];



if (isset($_POST['edit'])) {
    $errors = validate($_POST, ['name', 'email', 'password']);
    if (count($errors) <= 0) {
        $dataUpdate = [
            'id' => $user['id'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => md5($_POST['password']),
        ];


        $user = User::update($dataUpdate);
        $_SESSION['message'] = "Update success";
        $errors = [];
        header("location:./index.php");
    }
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div>
            <h1>Edit User</h1>
        </div>
        <div>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" name="email" value="<?= $user['email'] ?>" class=" form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="text-danger">
                        <?php echo isset($errors['email']) ? $errors['email'] : "" ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Name</label>
                    <input type="text" name="name" value="<?= $user['name'] ?>" class="form-control">
                    <div class="text-danger">
                        <?php echo isset($errors['name']) ? $errors['name'] : "" ?>

                    </div>
                </div>


                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    <div class="text-danger">
                        <?php echo isset($errors['password']) ? $errors['password'] : "" ?>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="edit">Update</button>
            </form>
        </div>
    </div>
    </div>










    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>