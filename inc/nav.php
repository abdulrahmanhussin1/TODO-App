<?php 
require_once 'inc/header.php';
require_once 'App.php';
?>
<nav class="navbar bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/R.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            TODO APP
        </a>

        <div>
            <ul class="nav justify-content-end">  
            <?php
            if(!$session->hasGetSession("loggedIn")){?>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">Sign up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php }else{ ?>
                <?php if($_SERVER['PHP_SELF'] == "/Github/To_Do_List/index.php"): ?>
                <li class="nav-item">
                    <a class="nav-link" href="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Task</a>
                </li>
                <?php endif;?>

                <li class="nav-item">
                    <a class="nav-link" href="handle/auth/logout.php">Logout</a>
                </li>

                <?php } ?>
            </ul>

</nav>