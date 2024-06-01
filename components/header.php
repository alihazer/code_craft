<?php
include 'config/dbConnect.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header('location:login.php');
}

?>

<header class="header">

    <section class="flex">

        <a href="home.html" class="logo">Code Craft</a>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div class="icons">
                <!-- Logout btn -->
                <a href="index.php?logout=true" class="fas fa-sign-out-alt"></a>
            </div>
        </div>


    </section>

</header>