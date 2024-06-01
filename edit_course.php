<?php
session_start();

$course_id = $_GET['id'];
include 'config/dbConnect.php';
$query = "SELECT * FROM courses WHERE id = $course_id";
$result = mysqli_query($conn, $query);
$course = mysqli_fetch_assoc($result);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $category_id = $_POST['category'];
    $lectures_nb = $_POST['lectures'];
    $teacher_id = $_SESSION['user_info']['id'];

    // Update the course
    $query = "UPDATE courses SET name = '$name', description = '$description', image = '$image', category_id = $category_id, lectures_nb = $lectures_nb, teacher_id = $teacher_id WHERE id = $course_id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location:index.php');
    } else {
        echo 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="./public/styles.css">

</head>

<body>

    <?php include 'components/header.php';
    include 'components/sidebar.php'
    ?>

    <section class="form-container">
        <h1 class="heading">Edit Course</h1>
        <div class="box-container">
            <div class="box">
                <form id="uploadForm" action="edit_course.php?id=<?php echo $course['id'] ?>" method="post">
                    <h3 class="title">Edit Course:</h3>
                    <input type="text" name="name" placeholder="Enter Course Name" required class="box" value="<?php echo $course['name'] ?>">
                    <input type="text" name="description" placeholder="Enter Course Description" required class="box" value="<?php echo $course['description'] ?>">
                    <img width="90%" src="<?php echo $course['image'] ?>" alt="">
                    <!-- Image -->
                    <input type="file" id="fileInput" accept="image/*" class="box">
                    <input type="hidden" name="image" id="image" value="<?php echo $course['image'] ?>" required>
                    <select name="category" class="box">
                        <option value="">Select Category</option>
                        <?php
                        include 'config/dbConnect.php';
                        $query = "SELECT * FROM categories";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <?php
                            if ($row['id'] == $course['category_id']) { ?>
                                <option value="<?php echo $row['id'] ?>" selected><?php echo $row['name'] ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                            <?php } ?>
                        <?php
                        }
                        ?>
                    </select>
                    <!-- Lectures mb -->
                    <input type="number" value="<?php echo $course['lectures_nb'] ?>" name=" lectures" placeholder="Enter Number of Lectures" required class="box">
                    <button type="submit" class="btn">Edit Course</button>
                </form>
            </div>
        </div>
    </section>


    <script type="module">
        import {
            initializeApp
        } from 'https://www.gstatic.com/firebasejs/10.12.1/firebase-app.js';
        import {
            getStorage,
            ref,
            uploadBytesResumable,
            getDownloadURL
        } from 'https://www.gstatic.com/firebasejs/10.12.1/firebase-storage.js';

        // Your Firebase config object
        const firebaseConfig = {
            apiKey: "AIzaSyB7EtSRJq0rdXeEtAP5JGkJnTmuQYQpxF4",
            authDomain: "code-craft-dbf37.firebaseapp.com",
            projectId: "code-craft-dbf37",
            storageBucket: "code-craft-dbf37.appspot.com",
            messagingSenderId: "957815087348",
            appId: "1:957815087348:web:fefa1a0d560c7a37babea1",
            measurementId: "G-THXDGZZS07"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const storage = getStorage(app);

        // Handle form submission
        const image = document.getElementById('image');
        const form = document.getElementById('uploadForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];

            if (file) {
                const storageRef = ref(storage, 'images/' + file.name);
                const uploadTask = uploadBytesResumable(storageRef, file);

                uploadTask.on('state_changed',
                    function(snapshot) {
                        // Observe state change events such as progress, pause, and resume
                        const progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                        console.log('Upload is ' + progress + '% done');
                    },
                    function(error) {
                        // Handle unsuccessful uploads
                        console.error('Upload failed:', error);
                    },
                    function() {
                        // Handle successful uploads
                        getDownloadURL(uploadTask.snapshot.ref).then(function(downloadURL) {
                            console.log('File available at', downloadURL);
                            image.value = downloadURL;
                            form.submit();
                        });
                    }
                );
            } else {
                console.error('No file selected');
                form.submit();
            }
        });
    </script>
    <script src="./public/script.js"></script>



</body>

</html>