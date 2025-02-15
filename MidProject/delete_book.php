<?php
session_start();
include("book_db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_GET['Id'])) {
    $user_id = $_SESSION["user_id"];
    $Id = $_GET['Id'];

    $sql_check = "SELECT * FROM book WHERE Id='$Id' AND user_id='$user_id'";
    $result_check = mysqli_query($kon, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        $sql = "DELETE FROM book WHERE Id='$Id' AND user_id='$user_id'";

        if (mysqli_query($kon, $sql)) {
            $_SESSION["delete"] = "Book Deleted Successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION["delete_error"] = "Something went wrong. Please try again.";
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $_SESSION["delete_error"] = "Book does not exist or you do not have permission to delete it.";
        header("Location: dashboard.php");
        exit();
    }
} else {
    $_SESSION["delete_error"] = "Invalid book ID.";
    header("Location: dashboard.php");
    exit();
}
?>