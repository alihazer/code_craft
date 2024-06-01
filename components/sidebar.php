<?php
$name = $_SESSION['user_info']['name'];
$role = $_SESSION['user_info']['role'];
?>
<div class="side-bar">

    <div id="close-btn">
        <i class="fas fa-times"></i>
    </div>

    <div class="profile">
        <img src="images/pic-1.jpg" class="image" alt="">
        <h3 class="name"><?php echo $name; ?></h3>
        <p class="role">
            <?php echo $role; ?>
        </p>
        <a href="profile.php" class="btn">view profile</a>
    </div>

    <nav class="navbar">
        <a href="/code_craft"><i class="fas fa-home"></i><span>Home</span></a>
        <a href="/code_craft"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
        <a href="contact.php"><i class="fas fa-headset"></i><span>Contact us</span></a>
    </nav>

</div>