<?php
include 'config/dbConnect.php';
session_start();
if (!isset($_SESSION['user_info'])) {
    header('location:login.php');
}

$role = $_SESSION['user_info']['role'];

$categoriesQuery = "SELECT * FROM categories";
$query = mysqli_query($conn, $categoriesQuery);
$categories = [];
while ($row = mysqli_fetch_assoc($query)) {
    $categories[] = $row;
}

$coursesQuery = "SELECT 
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
                    JOIN users ON users.id = courses.teacher_id";

$query2 = mysqli_query($conn, $coursesQuery);
$courses = [];
while ($row = mysqli_fetch_assoc($query2)) {
    $courses[] = $row;
}


if (isset($_GET['delete_category'])) {
    $id = $_GET['delete_category'];
    $deleteQuery = "DELETE FROM categories WHERE id = $id";
    mysqli_query($conn, $deleteQuery);
    header('location:index.php');
}

//Pending Enrolled courses for students
if ($role == 'student') {
    $enrolledQuery = "SELECT * FROM course_user WHERE user_id = {$_SESSION['user_info']['id']} and Finished = 0";
    $query3 = mysqli_query($conn, $enrolledQuery);
    $enrolledCourses = [];
    while ($row = mysqli_fetch_assoc($query3)) {
        $enrolledCourses[] = $row;
    }
    // Finished courses
    $finishedQuery = "SELECT * FROM course_user WHERE user_id = {$_SESSION['user_info']['id']} and Finished = 1";
    $query4 = mysqli_query($conn, $finishedQuery);
    $finishedCourses = [];
    while ($row = mysqli_fetch_assoc($query4)) {
        $finishedCourses[] = $row;
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
    <?php
    include 'components/header.php';
    include 'components/sidebar.php';
    ?>
    <section class="home-grid">


        <h1 class="heading">Options</h1>
        <?php if ($role == 'teacher') : ?>
            <div class="teacher_actions">
                <button class="inline-option-btn"><a href="add_category.php">Add Category</a></button>
                <button class="inline-option-btn"><a href="add_course.php">Add Course</a></button>
            </div>
        <?php endif; ?>
        <div class="box-container">
            <div class="box">
                <h3 class="title">Categories:</h3>
                <?php if ($role == 'teacher') : ?>

                    <div class="flex">
                        <?php foreach ($categories as $category) : ?>
                            <div class="category-item">
                                <a href="#"><span><?= $category['name'] ?></span></a>
                                <a href="edit_category.php?id=<?= $category['id'] ?>"><i class="fas fa-edit"></i></a>
                                <a href="index.php?delete_category=<?= $category['id'] ?>"><i class="fas fa-trash"></i></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="flex">
                        <?php foreach ($categories as $category) : ?>
                            <a href="#"><span><?= $category['name'] ?></span></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="courses">

        <h1 class="heading">our courses</h1>

        <div class="box-container">

            <?php foreach ($courses as $course) : ?>
                <div class="box">
                    <div class="tutor">
                        <img src="images/pic-1.jpg" alt="">
                        <div class="info">
                            <h3><?php echo $course['teacher_name'] ?></h3>
                            <span><?php echo $course['created_at'] ?></span>
                        </div>
                    </div>
                    <div class="thumb">
                        <img src="<?php echo $course['image'] ?>" alt="">
                        <span><?php echo $course['lectures_nb'] ?> lectures</span>
                        <span><?php echo $course['category_name'] ?></span>
                    </div>


                    <h3 class="title"><?php echo $course['course_name'] ?></h3>
                    <p><?php echo $course['description'] ?></p>
                    <center><a href="course.php?id=<?php echo $course['id'] ?>" class="inline-btn">View Course</a></center>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    <!-- Enrolled courses for student -->
    <?php if ($role == 'student') : ?>
        <section class="courses">
            <h1 class="heading">In Progress Courses</h1>
            <div class="box-container">
                <?php foreach ($enrolledCourses as $enrolledCourse) : ?>
                    <?php
                    $courseId = $enrolledCourse['course_id'];
                    $courseQuery = "SELECT 
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
                                        WHERE courses.id = $courseId";
                    $query4 = mysqli_query($conn, $courseQuery);
                    $course = mysqli_fetch_assoc($query4);
                    ?>
                    <div class="box">
                        <div class="tutor">
                            <img src="images/pic-1.jpg" alt="">
                            <div class="info">
                                <h3><?php echo $course['teacher_name'] ?></h3>
                                <span><?php echo $course['created_at'] ?></span>
                            </div>
                        </div>
                        <div class="thumb">
                            <img src="<?php echo $course['image'] ?>" alt="">
                            <span><?php echo $course['lectures_nb'] ?> lectures</span>
                            <span><?php echo $course['category_name'] ?></span>
                        </div>
                        <h3 class="title"><?php echo $course['course_name'] ?></h3>
                        <p><?php echo $course['description'] ?></p>
                        <center><a href="course.php?id=<?php echo $course['id'] ?>" class="inline-btn">Continue Course</a></center>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <!-- Finished Courses -->
        <section class="courses">
            <h1 class="heading">Finished Courses</h1>
            <div class="box-container">
                <?php foreach ($finishedCourses as $finishedCourse) : ?>
                    <?php
                    $courseId = $finishedCourse['course_id'];
                    $courseQuery = "SELECT 
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
                                        WHERE courses.id = $courseId";
                    $query4 = mysqli_query($conn, $courseQuery);
                    $course = mysqli_fetch_assoc($query4);
                    ?>
                    <div class="box">
                        <div class="tutor">
                            <img src="images/pic-1.jpg" alt="">
                            <div class="info">
                                <h3><?php echo $course['teacher_name'] ?></h3>
                                <span><?php echo $course['created_at'] ?></span>
                            </div>
                        </div>
                        <div class="thumb">
                            <img src="<?php echo $course['image'] ?>" alt="">
                            <span><?php echo $course['lectures_nb'] ?> lectures</span>
                            <span><?php echo $course['category_name'] ?></span>
                        </div>
                        <h3 class="title"><?php echo $course['course_name'] ?></h3>
                        <p><?php echo $course['description'] ?></p>
                        <center><a href="course.php?id=<?php echo $course['id'] ?>" class="inline-btn">View Course</a></center>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <script src="./public/script.js"></script>
</body>

</html>