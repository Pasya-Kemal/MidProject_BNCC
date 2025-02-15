<?php
session_start();
include "book_db.php"; 

if (!isset($_SESSION["user_id"])) {
    header("Location: dashboard.php"); 
    exit();
}

$user_id = $_SESSION["user_id"]; 

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    $sql = "SELECT * FROM book WHERE Id = '$book_id' AND user_id = '$user_id'";
    $result = mysqli_query($kon, $sql);

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error'] = "Book not found or you don't have permission to edit it.";
        header("Location: book_list.php");
        exit();
    }

    $book = mysqli_fetch_array($result);
} else {
    $_SESSION['error'] = "Invalid book ID.";
    header("Location: book_list.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($kon, $_POST["name"]);
    $author = mysqli_real_escape_string($kon, $_POST["author"]);
    $publisher = mysqli_real_escape_string($kon, $_POST["publisher"]);
    $number_of_page = (int)$_POST["number_of_page"];

    $update_sql = "UPDATE book SET name='$name', author='$author', publisher='$publisher', number_of_page='$number_of_page' WHERE Id='$book_id' AND user_id='$user_id'";

    if (mysqli_query($kon, $update_sql)) {
        $_SESSION['success'] = "Book updated successfully!";
        header("Location: book_list.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating the book.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Update Book</h2>

    <!-- Display error or success messages -->
    <?php if (isset($_SESSION["error"])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></div>
    <?php } ?>
    <?php if (isset($_SESSION["success"])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?></div>
    <?php } ?>

    <!-- Book Update -->
    <form method="POST">
        <div class="form-group">
            <label for="name">Book Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $book['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" name="author" class="form-control" value="<?php echo $book['author']; ?>" required>
        </div>
        <div class="form-group">
            <label for="publisher">Publisher</label>
            <input type="text" name="publisher" class="form-control" value="<?php echo $book['publisher']; ?>" required>
        </div>
        <div class="form-group">
            <label for="number_of_page">Number of Pages</label>
            <input type="number" name="number_of_page" class="form-control" value="<?php echo $book['number_of_page']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
</div>
</body>
</html>