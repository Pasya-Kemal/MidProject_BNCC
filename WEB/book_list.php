<?php
session_start();
include "book_db.php"; 

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: dashboard.php"); 
    exit();
}

$user_id = $_SESSION["user_id"]; 

$sql = "SELECT * FROM book WHERE user_id = '$user_id' ORDER BY Id DESC";
$hasil = mysqli_query($kon, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Registered Books</h2>

    <!-- Validation -->
    <?php if (isset($_SESSION["success"])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?></div>
    <?php } ?>
    <?php if (isset($_SESSION["error"])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></div>
    <?php } ?>

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
            <?php while ($data = mysqli_fetch_array($hasil)) { ?>
                <tr>
                    <td><?php echo $data["Id"]; ?></td>
                    <td><?php echo $data["name"]; ?></td>
                    <td><?php echo $data["author"]; ?></td>
                    <td><?php echo $data["publisher"]; ?></td>
                    <td><?php echo $data["number_of_page"]; ?></td>
                    <td>
                        <!-- update the book -->
                        <a href="update_book.php?id=<?php echo $data['Id']; ?>" class="btn btn-warning">Update</a>

                        <!-- delete the book -->
                        <a href="delete_book.php?Id=<?php echo $data['Id']; ?>&user_id=<?php echo $user_id; ?>" 
                           class="btn btn-danger"
                           onclick="return confirm('Are you sure you want to delete this book?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="register_book.php" class="btn btn-primary">Register New Book</a>
</div>
</body>
</html>