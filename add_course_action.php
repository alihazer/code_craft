<?php
session_start();
include 'config/dbConnect.php';
$name = $_POST['name'];
$description = $_POST['description'];
$image = $_POST['image'];
$category_id = $_POST['category'];
$lectures_nb = $_POST['lectures'];
$teacher_id = $_SESSION['user_info']['id'];

$query = "INSERT INTO courses(name, description, image, category_id, lectures_nb, teacher_id) VALUES('$name', '$description', '$image', $category_id, $lectures_nb, $teacher_id)";
$result = mysqli_query($conn, $query);
if ($result) {
    header('location:index.php');
} else {
    echo 'error';
}
