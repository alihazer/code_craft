<?php
include 'config/dbConnect.php';
session_start();
if (!isset($_SESSION['user_info'])) {
    header('location:login.php');
}
if (!isset($_POST['id'])) {
    header('location:index.php');
}
$course_id = $_GET['id'];
$query = "INSERT INTO course_user (course_id, user_id) VALUES ($course_id, {$_SESSION['user_info']['id']})";
$result = mysqli_query($conn, $query);
if ($result) {
    $_SESSION['$message'] = "You have successfully enrolled in the course";
    header('location:course.php?id=' . $course_id);
} else {
    $_SESSION['$message'] = "An error occurred";
}
