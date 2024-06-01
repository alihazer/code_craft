<?php

include 'config/dbConnect.php';
session_start();
if (!isset($_SESSION['user_info'])) {
    header('location:login.php');
}
$course_id = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lecture</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="./public/styles.css">
</head>

<body>
    <?php include 'components/header.php';
    include 'components/sideBar.php'
    ?>

    <section class="form-container">
        <h1 class="heading">Add Lecture</h1>
        <div class="box-container">
            <div class="box">
                <form id="uploadForm" action="add_lecture_action.php" method="post" enctype="multipart/form-data">
                    <h3 class="title">Add Lecture:</h3>
                    <p>Name:</p>
                    <input type="hidden" name="course_id" value="<?php echo $course_id ?>">
                    <input type="text" name="name" placeholder="Enter Lecture Name" required class="box">
                    <p>Description:</p>
                    <input type="text" name="description" placeholder="Enter Lecture Description" required class="box">
                    <p>Video:</p>
                    <input type="text" name="youtube_video" required class="box">
                    <!-- Image -->
                    <p>Image:</p>
                    <input type="file" id="fileInput" required class="box">
                    <input type="hidden" name="image" id="image" required>
                    <button type="submit" class="btn">Add Lecture</button>

                </form>
            </div>
        </div>
    </section>

    <script src="./public/script.js"></script>
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
            }
        });
    </script>
</body>

</html>