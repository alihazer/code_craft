<?php
session_start();
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
        <h1 class="heading">Add Course</h1>
        <div class="box-container">
            <div class="box">
                <form id="uploadForm" action="add_course_action.php" method="post">
                    <h3 class="title">Add Course:</h3>
                    <input type="text" name="name" placeholder="Enter Course Name" required class="box">
                    <input type="text" name="description" placeholder="Enter Course Description" required class="box">
                    <!-- Image -->
                    <input type="file" id="fileInput" accept="image/*" required class="box">
                    <input type="hidden" name="image" id="image" required>
                    <select name="category" class="box">
                        <option value="">Select Category</option>
                        <?php
                        include 'config/dbConnect.php';
                        $query = "SELECT * FROM categories";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <!-- Lectures mb -->
                    <input type="number" name="lectures" placeholder="Enter Number of Lectures" required class="box">
                    <button type="submit" class="btn">Add Course</button>
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
                            form.action = 'add_course_action.php';
                            form.submit();
                        });
                    }
                );
            } else {
                console.error('No file selected');
            }
        });
    </script>
    <!-- <script src="./public/script.js"></script> -->



</body>

</html>