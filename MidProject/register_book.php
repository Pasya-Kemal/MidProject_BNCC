<?php
session_start();
include "book_db.php"; 

if (!isset($_SESSION["user_id"])) {
    header("Location: dashboard.php"); 
    exit();
}

$user_id = $_SESSION["user_id"]; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate form fields
    if (!empty($_POST["Id"]) && !empty($_POST["name"]) && !empty($_POST["author"]) && !empty($_POST["publisher"]) && !empty($_POST["number_of_page"])) {
        
        $Id = (int)$_POST["Id"];
        $name = mysqli_real_escape_string($kon, $_POST["name"]);
        $author = mysqli_real_escape_string($kon, $_POST["author"]);
        $publisher = mysqli_real_escape_string($kon, $_POST["publisher"]);
        $number_of_page = (int)$_POST["number_of_page"];

        $sql = "INSERT INTO book (Id, name, author, publisher, number_of_page, user_id) 
                VALUES ('$Id', '$name', '$author', '$publisher', '$number_of_page', '$user_id')";
        
        if (mysqli_query($kon, $sql)) {
            header("Location: dashboard.php?success=Book%20successfully%20registered!");
            exit(); 
        } else {
            $error = "Error: " . mysqli_error($kon);
        }
    } else {
        $error = "All fields must be filled.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Register a Book</h2>
    
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Book ID:</label>
            <input type="number" name="Id" class="form-control" placeholder="Enter Book ID" required />
        </div>
        <div class="form-group">
            <label>Book Name:</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Book Name" required />
        </div>
        <div class="form-group">
            <label>Author:</label>
            <input type="text" name="author" class="form-control" placeholder="Enter Author Name" required />
        </div>
        <div class="form-group">
            <label>Publisher:</label>
            <input type="text" name="publisher" class="form-control" placeholder="Enter Publisher Name" required />
        </div>
        <div class="form-group">
            <label>Number of Pages:</label>
            <input type="number" name="number_of_page" class="form-control" placeholder="Enter Number of Pages" required />
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Register Book</button>
    </form>
</div>
</body>
</html>