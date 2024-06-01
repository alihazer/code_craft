<?php
include 'config/dbConnect.php';
$name = $_POST['name'];

$query = "INSERT INTO categories(name) VALUES('$name')";
$result = mysqli_query($conn, $query);
if ($result) {
    header('location:index.php');
} else {
    echo 'error';
}
