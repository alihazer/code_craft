<?php
include 'config/dbConnect.php';
session_start();
$email = $_POST['email'];
$pass = $_POST['pass'];

$query = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    session_start();
    $_SESSION['user_info'] = $row;
    header('location: /code_craft');
} else {
    $_SESSION['error'] = 'Invalid email or password';
    header('location:login.php');
}
