<?php
session_start();
include 'config/dbConnect.php';

if (!isset($_SESSION['user_info'])) {
    header('location:login.php');
    exit(); // Always exit after a header redirect
}

$user = $_SESSION['user_info'];
$isTeacher = $user['role'] == 'teacher';
$user_id = (int)$user['id'];

if (!$isTeacher) {
    $query = "SELECT * FROM course_user WHERE user_id = $user_id";
    $query2 = mysqli_query($conn, $query);

    $courses = [];
    while ($row = mysqli_fetch_assoc($query2)) {
        $courses[] = $row;
    }

    $totalCourses = count($courses);
    $finishedCourses = 0;

    foreach ($courses as $course) {
        if ($course['finished'] == 1) {
            $finishedCourses++;
        }
    }
    $startedCourses = $totalCourses - $finishedCourses;
} else {
    $query = "SELECT count(id) FROM courses WHERE teacher_id = $user_id";
    $query2 = mysqli_query($conn, $query);
    $courses = mysqli_fetch_assoc($query2);

    $totalCourses = count($courses);
    $studentsQuery = "SELECT distinct count(user_id) FROM course_user where course_id in (SELECT id FROM courses WHERE teacher_id = $user_id)";
    $studentsQuery2 = mysqli_query($conn, $studentsQuery);
    $students = mysqli_fetch_assoc($studentsQuery2);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="public/styles.css">
</head>

<body>
    <?php include 'components/header.php';
    include 'components/sideBar.php'
    ?>
    <section class="user-profile">

        <h1 class="heading">Your profile</h1>

        <div class="info">

            <div class="user">
                <img src="images/pic-1.jpg" alt="">
                <h3><?php echo $user['name'] ?></h3>
                <p><?php echo $user['role'] ?></p>
            </div>

            <?php if (!$isTeacher) : ?>
                <div class="box-container">

                    <div class="box">
                        <div class="flex">
                            <i class="fas fa-bookmark"></i>
                            <div>
                                <span><?php echo $totalCourses ?></span>
                                <p>Enrolled Courses</p>
                            </div>
                        </div>

                    </div>

                    <div class="box">
                        <div class="flex">
                            <i class="fas fa-heart"></i>
                            <div>
                                <span><?php echo $startedCourses ?> </span>
                                <p>In Progress Courses</p>
                            </div>
                        </div>

                    </div>

                    <div class="box">
                        <div class="flex">
                            <i class="fas fa-comment"></i>
                            <div>
                                <span><?php echo $finishedCourses ?></span>
                                <p>Finished Courses</p>
                            </div>
                        </div>

                    </div>
                    <a href="/code_craft" class="btn">View Courses</a>

                </div>
            <?php else : ?>
                <div class="box-container">

                    <div class="box">
                        <div class="flex">
                            <i class="fas fa-bookmark"></i>
                            <div>
                                <span><?php echo $courses['count(id)'] ?></span>
                                <p>Created Courses</p>
                            </div>
                        </div>

                    </div>

                    <div class="box">
                        <div class="flex">
                            <i class="fas fa-heart"></i>
                            <div>
                                <span><?php echo count($students) ?> </span>
                                <p>Students</p>
                            </div>
                        </div>

                    </div>

                    <a href="/code_craft" class="btn">View Courses</a>

                </div>
            <?php endif; ?>
        </div>

    </section>

    <script src="public/script.js"></script>

</body>

</html>