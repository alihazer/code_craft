<?php

session_start();
include 'config/dbConnect.php';
$lecture_id = $_GET['id'];
$query = "SELECT lectures.*, 
        courses.name as course_id, 
        users.name as teacher_name
        FROM lectures 
        JOIN courses ON lectures.course_id = courses.id 
        JOIN users ON courses.teacher_id = users.id 
        WHERE lectures.id = $lecture_id";

$query2 = mysqli_query($conn, $query);
$lecture = mysqli_fetch_assoc($query2);

$youtubeUrl = $lecture['youtube_video'];
$youtubeId = explode('=', $youtubeUrl)[1];
var_dump($youtubeId);
var_dump($youtubeUrl);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lecture['name'] ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="public/styles.css">
</head>

<body>
    <?php include 'components/header.php';
    include 'components/sideBar.php'
    ?>
    <section class="user-profile">
        <div class="box">
            <h1 style="color: white;"><?php echo $lecture['name'] ?></h1>
            <p><?php echo $lecture['description'] ?></p>
            <p>Course: <?php echo $lecture['course_id'] ?></p>
            <p>Teacher: <?php echo $lecture['teacher_name'] ?></p>
        </div>
        <!-- Embed youtube video -->
        <iframe width="70%" height="360" src="https://www.youtube.com/embed/<?php echo $youtubeId ?>" frameborder="0" allowfullscreen></iframe>
    </section>
    <script src="public/script.js"></script>
</body>

</html>