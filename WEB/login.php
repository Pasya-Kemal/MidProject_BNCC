<?php
session_start(); 

include "user_db.php"; 

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["id"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
        $id = $_POST["id"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM user WHERE id = '$id' AND username = '$username'";
        $result = mysqli_query($kon, $sql);

        if ($result) {
            $user = mysqli_fetch_assoc($result);

            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                header("Location: dashboard.php"); 
                exit;
            } else {
                $error = "Login gagal. ID, username, atau password salah.";
            }
        } else {
            $error = "Error dalam query.";
        }
    } else {
        $error = "Semua kolom harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Login User</h2>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>User ID:</label>
            <input type="text" name="id" class="form-control" placeholder="Masukkan User ID" required />
        </div>
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required />
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required />
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Login</button>
    </form>

    <!-- Don't have an account -->
    <div class="mt-3">
        <a href="create_user.php" class="btn btn-secondary">Create Account</a>
    </div>
</div>
</body>
</html>