<?php
include 'config/dbConnect.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="./public/styles.css">
</head>

<body>
    <?php include 'components/header.php';
    include 'components/sideBar.php'
    ?>

    <!-- Add Vategory -->
    <section class="form-container">
        <h1 class="heading">Add Category</h1>
        <div class="box-container">
            <div class="box">
                <form action="add_category_action.php" method="post">
                    <h3 class="title">Add
                        Category:</h3>
                    <input type="text" name="name" placeholder="Enter Category Name" required class="box">
                    <button type="submit" class="btn">Add Category</button>
                </form>
            </div>
        </div>
    </section>

    <script src="./public/script.js"></script>
</body>


</html>