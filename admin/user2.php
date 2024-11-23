<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';

// معالجة إضافة مستخدم
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = "INSERT INTO users_data(username, email, role) VALUES ('$username', '$email', '$role')";
    $conn->query($query);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// معالجة تعديل مستخدم
if (isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = "UPDATE users_data SET username='$username', email='$email', role='$role' WHERE userID=$id";
    $conn->query($query);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// معالجة حذف مستخدم
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM users_data WHERE userID=$id";
    $conn->query($query);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// جلب بيانات الأدمنز
$query_admins = "SELECT * FROM users_data WHERE role='admin'";
$result_admins = $conn->query($query_admins);

// جلب بيانات المستخدمين
$query_users = "SELECT * FROM users_data WHERE role='user'";
$result_users = $conn->query($query_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Manage Users</h2>

    <!-- Form إضافة أو تعديل المستخدم -->
    <form method="POST" class="mb-4">
        <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required 
                       value="<?= isset($_GET['edit']) ? $conn->query("SELECT username FROM users_data WHERE userID={$_GET['edit']}")->fetch_assoc()['username'] : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required 
                       value="<?= isset($_GET['edit']) ? $conn->query("SELECT email FROM users_data WHERE userID={$_GET['edit']}")->fetch_assoc()['email'] : '' ?>">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-control" required>
                    <option value="admin" <?= isset($_GET['edit']) && $conn->query("SELECT role FROM users_data WHERE userID={$_GET['edit']}")->fetch_assoc()['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= isset($_GET['edit']) && $conn->query("SELECT role FROM users_data WHERE userID={$_GET['edit']}")->fetch_assoc()['role'] == 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-<?= isset($_GET['edit']) ? 'warning' : 'primary' ?> w-100" name="<?= isset($_GET['edit']) ? 'edit_user' : 'add_user' ?>">
                    <?= isset($_GET['edit']) ? 'Update User' : 'Add User' ?>
                </button>
            </div>
        </div>
    </form>

    <!-- جدول عرض الأدمنز -->
    <h3>Admins</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($admin = $result_admins->fetch_assoc()): ?>
                <tr>
                    <td><?= $admin['userID'] ?></td>
                    <td><?= $admin['username'] ?></td>
                    <td><?= $admin['email'] ?></td>
                    <td><?= $admin['role'] ?></td>
                    <td>
                        <a href="?edit=<?= $admin['userID'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?= $admin['userID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- جدول عرض المستخدمين -->
    <h3>Users</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result_users->fetch_assoc()): ?>
                <tr>
                    <td><?= $user['userID'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <a href="?edit=<?= $user['userID'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?= $user['userID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
