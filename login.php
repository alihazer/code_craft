<?php
if (isset($_SESSION['user_info'])) {
    header('location: /code_craft');
}
if (!isset($_SESSION)) {
    session_start();
}
var_dump($_SESSION);
$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
}
var_dump($error);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="./public/styles.css">

</head>

<body>

    <section class="form-container">
        <h1>Welcome Back</h1>
        <?php if (strlen($error) > 0) : ?>
            <div class="alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login_action.php" method="post" enctype="multipart/form-data">
            <h3>Login</h3>
            <p>Email:</p>
            <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
            <p>Password:</p>
            <input type="password" name="pass" placeholder="enter your password" required maxlength="20" class="box">
            <input type="submit" value="Login" name="submit" class="btn">
            <center>
                <p>Don't have an account? <a href="register.php">Register Now</a></p>
            </center>
        </form>

    </section>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>


</body>

</html>