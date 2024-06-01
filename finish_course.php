<?php

include 'config/dbConnect.php';
session_start();
if (!isset($_SESSION['user_info'])) {
    header('location:login.php');
}
$user_id = $_SESSION['user_info']['id'];
$course_id = $_GET['id'];
$query = "SELECT * FROM courses WHERE id = $course_id";
$query2 = mysqli_query($conn, $query);
$course = mysqli_fetch_assoc($query2);

$message = 'This course has already been finished';


// Request method is POST
if (isset($_GET['post']) &&  $_GET['post'] == true) {
    // Check if the user has already finished the course
    $checkQuery = "SELECT * FROM course_user WHERE user_id = $user_id AND course_id = $course_id";
    $checkResult = mysqli_query($conn, $checkQuery);
    $check = mysqli_fetch_assoc($checkResult);
    if ($check['finished'] == 1) {
        $message = 'You have already finished this course';
    } else {
        $message = 'Congratulations! You have successfully finished the course';
        $updateQuery = "UPDATE course_user SET finished = 1 WHERE user_id = $user_id AND course_id = $course_id";
        mysqli_query($conn, $updateQuery);
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finished Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="public/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body>
    <?php include 'components/header.php';
    include 'components/sideBar.php'
    ?>

    <section class="form-container">
        <?php
        if (strlen($message) > 0) {
        ?>
            <div class="alert-success">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php echo $message ?>
                <?php $message = '' ?>
            </div>
        <?php
        } ?>
        <h1 class="heading">Course details</h1>
        <h1 class="heading">Name: <?php echo $course['name'] ?></h3>
            <center>
                <div class="box-container">
                    <div class="box">

                        <p class="description"><?php echo $course['description'] ?></p>
                        <img width="40%" src="<?php echo $course['image'] ?>" alt="">
                        <p class="lectures">Number of lectures: <?php echo $course['lectures_nb'] ?></p>
                        <p class="category">
                            Category: <?php
                                        $category_id = $course['category_id'];
                                        $categoryQuery = "SELECT * FROM categories WHERE id = $category_id";
                                        $categoryResult = mysqli_query($conn, $categoryQuery);
                                        $category = mysqli_fetch_assoc($categoryResult);
                                        echo $category['name'];
                                        ?>
                        </p>
                        <p class="teacher">
                            Teacher: <?php
                                        $teacher_id = $course['teacher_id'];
                                        $teacherQuery = "SELECT * FROM users WHERE id = $teacher_id";
                                        $teacherResult = mysqli_query($conn, $teacherQuery);
                                        $teacher = mysqli_fetch_assoc($teacherResult);
                                        echo $teacher['name'];
                                        ?>
                        </p>
                        <p class="created">Created at: <?php echo $course['created_at'] ?></p>
                        <!-- Download certificate btn -->
                        <div class="btns">
                            <button class="inline-btn" onclick="generateCertificate()">Download certificate</button>
                            <a href="index.php" class="inline-btn">Back</a>
                        </div>
            </center>
            </div>
            </div>
    </section>
    <script>
        async function generateCertificate() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(40);
            doc.text("CODE CRAFT ACADEMY", 105, 20, null, null, 'center')
            doc.setFontSize(20);
            doc.text("Certificate of Completion", 105, 50, null, null, 'center');
            doc.setFontSize(16);
            doc.text("This is to certify that", 105, 70, null, null, 'center');
            doc.setFontSize(18);
            doc.text("<?php echo $_SESSION['user_info']['name']; ?>", 105, 90, null, null, 'center');
            doc.setFontSize(16);
            doc.text("has successfully completed the course", 105, 110, null, null, 'center');
            doc.setFontSize(18);
            doc.text("<?php echo $course['name']; ?>", 105, 130, null, null, 'center');
            doc.setFontSize(14);
            doc.text("Date: <?php echo date('Y-m-d'); ?>", 105, 150, null, null, 'center');
            doc.setFontSize(14);
            doc.text("Instructor: <?php echo $teacher['name']; ?>", 105, 170, null, null, 'center');
            doc.text("CEO s Signature: ", 170, 250, null, null, 'center')
            doc.text("Ali Hazer ", 170, 260, null, null, 'center')
            doc.text("Fatima Manaa", 170, 270, null, null, 'center')
            doc.save("certificate.pdf");
        }
    </script>
    <script src="public/script.js"></script>
</body>

</html>