<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="public/styles.css">
</head>

<body>
    <?php include 'components/header.php';
    include 'components/sideBar.php'
    ?>
    <section class="contact">
        <div class="row">
            <form action="" method="post">
                <h3>Get in touch</h3>
                <input type="text" placeholder="enter your name" name="name" required maxlength="50" class="box">
                <input type="email" placeholder="enter your email" name="email" required maxlength="50" class="box">
                <input type="number" placeholder="enter your number" name="number" required maxlength="50" class="box">
                <textarea name="msg" class="box" placeholder="enter your message" required maxlength="1000" cols="30" rows="10"></textarea>
                <input type="submit" value="send message" class="inline-btn" name="submit">
            </form>
        </div>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-phone"></i>
                <h3>phone number</h3>
                <a href="tel:81717464">+961 81717464</a>
            </div>

            <div class="box">
                <i class="fas fa-envelope"></i>
                <h3>email address</h3>
                <a href="mailto:contact@codecraft.com">contact@codecraft.com</a>
            </div>


        </div>

    </section>
    <script src="public/script.js"></script>
</body>

</html>