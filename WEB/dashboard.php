<?php
session_start();
include("book_db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: register_user.php");
    exit();
}

$user_id = $_SESSION["user_id"];  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .nav-link {
            color: #495057;
        }
        .nav-link:hover {
            color: #007bff;
        }
        .logout-btn {
            position: absolute;
            top: 60px;
            right: 60px;
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<!-- Logout Button -->
<a href="logout.php" class="logout-btn">Logout</a>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Book Management</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="register_book.php">Register Book</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="book_list.php">Book List</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Welcome to the Book Management Dashboard</h2>

    <!-- Display Success or Error Messages -->
    <?php if (isset($_SESSION["success"])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?></div>
    <?php } ?>
    <?php if (isset($_SESSION["error"])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></div>
    <?php } ?>

    <!-- Book List Section -->
    <div class="card mt-4">
        <div class="card-header">
            Registered Books
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Number of Pages</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM book WHERE user_id = '$user_id' ORDER BY Id DESC";
                    $result = mysqli_query($kon, $sql);
                    while ($data = mysqli_fetch_array($result)) {
                        echo "<tr>
                                <td>{$data['Id']}</td>
                                <td>{$data['name']}</td>
                                <td>{$data['author']}</td>
                                <td>{$data['publisher']}</td>
                                <td>{$data['number_of_page']}</td>
                                <td>
                                    <a href='update_book.php?id={$data['Id']}' class='btn btn-warning'>Update</a>
                                    <a href='delete_book.php?Id={$data['Id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this book?\");'>Delete</a>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Book Button -->
    <div class="mt-4">
        <a href="register_book.php" class="btn btn-success">Add a Book</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
</body>
</html>