<?php
session_start();
include 'config/dbConnect.php';
$categoryId = $_GET['id'];
$query = "SELECT * FROM categories WHERE id = $categoryId";
$result = mysqli_query($conn, $query);
$category = mysqli_fetch_assoc($result);
if (!$category) {
    header('location:not_found.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $query = "UPDATE categories SET name = '$name' WHERE id = $categoryId";
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
        <h1 class="heading">Edit Category</h1>
        <div class="box-container">
            <div class="box">
                <form action="edit_category.php?id=<?php echo $categoryId ?>" method="post">
                    <h3 class="title">Edit
                        Category:</h3>
                    <input type="text" name="name" placeholder="Enter Category Name" required class="box" value="<?php echo $category['name'] ?>">
                    <button type="submit" class="btn">Edit Category</button>
                </form>
            </div>
        </div>
    </section>

    <script src="./public/script.js"></script>
</body>


</html>