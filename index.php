<?php
session_start();
include_once "./User.php";

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng đến login.php
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Cấu hình số bản ghi trên mỗi trang
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Lấy danh sách user có phân trang
$users = User::all($limit, $offset);
$totalUsers = User::count();
$totalPages = ceil($totalUsers / $limit);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thực hành với CRUD User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>User List</h1>

            <!-- Nếu đã đăng nhập, hiển thị nút Đăng xuất -->
            <?php if (isset($_SESSION['user'])) { ?>
                <div>
                    <span class="me-2">Xin chào, <?= $_SESSION['user']['name'] ?></span>
                    <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
                </div>
            <?php } else { ?>
                <a href="login.php" class="btn btn-primary">Đăng nhập</a>
            <?php } ?>
        </div>

        <a href="./create.php" class="btn btn-primary mt-3">Create</a>

        <div>
            <?php if (count($users) > 0) { ?>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <th><?= $user['id'] ?></th>
                                <td><?= $user['name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td>
                                    <a href="./show.php?id=<?= $user['id'] ?>" class="btn btn-info">Show</a>
                                    <a href="./edit.php?id=<?= $user['id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="./delete.php?id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h2>No Data</h2>
            <?php } ?>
        </div>

        <!-- Phân trang -->
        <nav>
            <ul class="pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php } ?>

                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>