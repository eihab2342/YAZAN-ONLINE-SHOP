<?php
    $result = mysqli_query($conn, "SELECT * from users_data");
        if($result) {
            $row = mysqli_fetch_assoc($result);
        }
?>
        
        <div class="sidebar pe-4 pb-3" style="width: 250">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="../admin/index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-warning"><i class="fa fa-user-edit me-2"></i>Yazan Shop</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="../uploads/img/eihab.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $row['username'] ?></h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    
                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous"><a href="../admin/index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="../admin/orders.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Orders</a>
                    <a href="../admin/category.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Categories</a>
                    <a href="../admin/coupons.php?do=Coupons" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Coupons</a>
                    <!-- <a href="form.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a> -->
                    <a href="../admin/product.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Products</a>
                    <!-- <a href="../admin/total_users.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Users</a> -->
                    <a href="../admin/users.php?do=Admins" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Admins</a>
                    <a href="../admin/contact.php" class="nav-item nav-link"><i class="fa fa-laptop me-2"></i>Contacts</a>
                    <!-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="../login.php" class="dropdown-item">Sign In</a>
                            <a href="../signup.php" class="dropdown-item">Sign Up</a>
                            <a href="../admin/404.php" class="dropdown-item">404 Error</a>
                            <a href="../admin/blank.php" class="dropdown-item">Blank Page</a>
                        </div>
                    </div> -->
                </div>
            </nav>
        </div>
