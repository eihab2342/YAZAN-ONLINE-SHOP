<?php 
    session_start();
    require '../config/connection.php';
    require '../config/functions.php';
    $result = mysqli_query($conn, "SELECT * FROM categories_data");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- bootstarp -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">     -->

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- bootstarp -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">     -->

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="../uploads/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../uploads/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../uploads/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../uploads/css/style.css" rel="stylesheet">
</head>
    

<body class=""> 

    <!-- Topbar Start -->
    <div class="container-fluid my-2">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">About</a>
                    <a class="text-body mr-3" href="../users/contact.php">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <!-- <a class="text-body mr-3" href="">FAQs</a> -->
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-dark dropdown-toggle p-2" data-toggle="dropdown">My Account</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button"><a href="../user/userInfo.php" style="color: black;">profile</a></button>
                            <a href="../../logout.php" style="color: black;"><button class="dropdown-item" type="button">Log out</button></a>
                        </div>
                    </div>
            </div>
        </div>

        <div class="container-fluid my-3 p-2">
                <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
                    <div class="col-lg-4 col-sm-4">
                        <a href="../../user/index.php" class="text-decoration-none">
                            <span class="h1 text-uppercase text-warning bg-dark px-2">YAZAN</span>
                            <span class="h1 text-uppercase text-dark bg-warning px-2 ml-n1">Shop</span>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-4 text-left">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for products">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-warning">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 text-right">
                        <h6 class="m-0 ">Customer Service</h6>
                            <a href="https://wa.me/+201119842314?text=أحتاج%20للمساعدة" target="_blank" class="text-info fs-20">
                                <i class="fab fa-whatsapp whatsapp-icon" style="color: #25D366; font-size: 32px;"></i> واتساب
                            </a>
                        <p class="m-0">eihab2342@gmail.com</p>
                    </div>
                </div>
                </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-warning w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                        <?php while($row = mysqli_fetch_assoc($result)) {  ?>
                            <a href="" class="nav-item nav-link"><?php echo $row['category_name'] ?></a>
                        <?php } ?>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">YAZAN</span>
                        <span class="h1 text-uppercase text-light bg-warning px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="../user/index.php" class="nav-item nav-link active">Home</a>
                            <a href="../user/shop.php" class="nav-item nav-link">Shop</a>
                            <a href="../user/detail.php" class="nav-item nav-link">Shop Detail</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="../user/cart.php" class="dropdown-item">Shopping Cart</a>
                                    <a href="../user/checkout.php" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-warning"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="../user/cart.php" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-warning"></i>
                                    <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
                                <?php echo countItems2('cart_id', 'cart') ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div> 
    <!-- Navbar End -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>