<?php
session_start();

include "user_db.php";

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $id = input($_POST["id"]);
    $username = input($_POST["username"]);
    $password = password_hash(input($_POST["password"]), PASSWORD_DEFAULT); 

    $sql = "INSERT INTO user (id, username, password) VALUES ('$id', '$username', '$password')";

    $hasil = mysqli_query($kon, $sql);

    if ($hasil) {
        // Redirect to login page 
        header("Location: login.php"); 
        exit;
    } else {
        echo "<div class='alert alert-danger'>Data Gagal disimpan.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Daftar User</h2>
    <form action="create_user.php" method="post">
        <div class="form-group">
            <label>User ID:</label>
            <input type="text" name="id" class="form-control" placeholder="Masukan User ID" required />
        </div>
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" placeholder="Masukan Username" required />
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Masukan Password" required />
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
</body>
</html>
