<?php
    session_start();
    require '../assets/header.php';
    require '../config/connection.php';
    require '../config/functions.php';
    ?>


<title><?php $pageTitle = 'Blank Page'; echo getTitle($pageTitle) ?></title>
<div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
            <?php require_once '../assets/sideBar.php'; ?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">

            <!-- Navbar Start -->
                <?php require_once '../assets/navBar.php'; ?>
            <!-- Navbar End -->


            <!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-secondary rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <h3>This is blank page</h3>
                    </div>
                </div>
            </div>
            <!-- Blank End -->


            <!-- Footer Start -->
        <?php require '../assets/footer.php' ?>