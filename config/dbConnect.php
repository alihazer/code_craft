<?php
$username = "root";
$password = "";
$hostname = "localhost";
$database = "code_craft";

//connection to the database
$conn = mysqli_connect($hostname, $username, $password)
    or die("Unable to connect to MySQL");
if ($conn) {
    mysqli_select_db($conn, $database);
}
