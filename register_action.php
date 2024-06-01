<?php
include 'config/dbConnect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$dob = $_POST['dob'];

$query = "INSERT INTO users(name,email,password,dob) VALUES('$name','$email','$pass','$dob')";
$result = mysqli_query($conn, $query);
if ($result) {
    header('location:login.php');
} else {
    echo 'error';
}
