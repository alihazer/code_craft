<?php
include 'config/dbConnect.php';
session_start();
$name = $_POST['name'];
$description = $_POST['description'];
$image = $_POST['image'];
$course_id = $_POST['course_id'];
$youtube_video = $_POST['youtube_video'];

$query = "INSERT INTO lectures(name, description, image, course_id, youtube_video) VALUES('$name', '$description', '$image', $course_id, '$youtube_video')";
$result = mysqli_query($conn, $query);
if ($result) {
    header('location:course.php?id=' . $course_id);
} else {
    echo 'error';
}
