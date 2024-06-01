<?php
include 'config/dbConnect.php';
session_start();
if (!isset($_SESSION['user_info'])) {
    header('location:login.php');
}
$course_id = $_GET['id'];
$query = "SELECT 
            courses.id,
            courses.name AS course_name, 
            courses.description, 
            courses.image, 
            courses.teacher_id, 
            courses.category_id, 
            courses.created_at, 
            courses.lectures_nb,
            categories.name AS category_name, 
            users.name AS teacher_name 
            FROM courses 
            JOIN categories ON categories.id = courses.category_id 
            JOIN users ON users.id = courses.teacher_id
            WHERE courses.id = $course_id";
$query2 = mysqli_query($conn, $query);
$course = mysqli_fetch_assoc($query2);
if (!$course) {
    header('location:not_found.php');
}

$lecturesQuery = "SELECT * FROM lectures WHERE course_id = $course_id";
$query3 = mysqli_query($conn, $lecturesQuery);
$lectures = [];
while ($row = mysqli_fetch_assoc($query3)) {
    $lectures[] = $row;
}


if (isset($_GET['delete'])) {
    $deleteQuery = "DELETE FROM courses WHERE id = $course_id";
    mysqli_query($conn, $deleteQuery);
    header('location:index.php');
}

// Check if the user is enrolled in the course
$enrolledQuery = "SELECT * FROM course_user WHERE course_id = $course_id AND user_id = {$_SESSION['user_info']['id']}";
$query4 = mysqli_query($conn, $enrolledQuery);
$enrolled = mysqli_fetch_assoc($query4);



if (isset($_GET['start'])) {
    $query = "UPDATE course_user SET started = 1 WHERE course_id = $course_id AND user_id = {$_SESSION['user_info']['id']}";
    $result = mysqli_query($conn, $query);
    if ($result) {

        header('location: course.php?id=' . $course_id);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="public/styles.css">
</head>

<body>
    <?php include 'components/header.php';
    include 'components/sideBar.php'
    ?>

    <section class="playlist-details">
        <h1 class="heading">Course details</h1>
        <?php
        if (isset($_SESSION['$message'])) {
        ?>
            <div class="alert-success">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php echo $_SESSION['$message'] ?>
                <?php unset($_SESSION['$message']) ?>
            </div>
        <?php
        } ?>

        <div class="row">

            <div class="column">

                <div class="thumb">
                    <img src="<?php echo $course['image'] ?>" alt="">
                    <span><?php echo $course['lectures_nb'] ?> Lectures</span>

                </div>
            </div>
            <div class="column">
                <div class="tutor">
                    <img src="images/pic-1.jpg" alt="">
                    <div>
                        <h3><?php echo $course['teacher_name'] ?></h3>
                        <span><?php echo $course['created_at'] ?></span>
                    </div>
                </div>

                <div class="details">
                    <h3><?php echo $course['course_name'] ?></h3>
                    <p><?php echo $course['description'] ?></p>
                    <?php if ($_SESSION['user_info']['id'] == $course['teacher_id']) { ?>
                        <a href="edit_course.php?id=<?php echo $course['id'] ?>" class="inline-option-btn">Edit Course</a>
                        <a href="add_lecture.php?id=<?php echo $course['id'] ?>" class="inline-option-btn">Add Lecture</a>
                        <a href="course.php?id=<?php echo $course['id'] ?>&delete=true" class="inline-delete-btn">Delete Course</a>

                    <?php } else { ?>
                        <?php if ($enrolled) { ?>
                            <?php if ($enrolled['started'] == 1 && $enrolled['finished'] == 0) { ?>
                                <a class="inline-option-btn">In Progress</a>
                            <?php } else if ($enrolled['finished'] == 1) { ?>
                                <a href="finish_course.php?id=<?php echo $course['id'] ?>" class="inline-option-btn"> Finished </a>
                            <?php } else { ?>
                                <a href="course.php?id=<?php echo $course['id'] ?>&start=true" class="inline-option-btn">Start Course</a>
                            <?php } ?>

                        <?php } else { ?>
                            <a href="enroll_course.php?id=<?php echo $course['id'] ?>" class="inline-option-btn">Enroll</a>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>
        </div>

    </section>

    <section class="playlist-videos">

        <h1 class="heading">Lectures:</h1>
        <div class="box-container">

            <?php foreach ($lectures as $lecture) : ?>
                <a class="box" href="lecture.php?id=<?php echo $lecture['id'] ?>">
                    <i class="fas fa-play"></i>
                    <img src="<?php echo $lecture['image'] ?>" alt="">
                    <h3><?php echo $lecture['name'] ?></h3>
                </a>
            <?php endforeach; ?>
        </div>

    </section>
    <!-- Finish course btn -->
    <?php if ($enrolled && $enrolled['started'] && $enrolled['finished'] == 0) { ?>
        <center><a href="finish_course.php?id=<?php echo $course['id'] ?>&post=true" class="inline-option-btn">Finish Course</a></center>
    <?php } ?>

    <script src="public/script.js"></script>
</body>

</html>