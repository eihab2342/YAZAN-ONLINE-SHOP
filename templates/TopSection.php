
<?php 
    if (isset($_POST['remove'])) {
        $cart_id = $_POST['cart_id']; 
        $delete_sql = "DELETE FROM cart WHERE cart_id = '$cart_id' AND userID = '$userID'";
        mysqli_query($conn, $delete_sql); 
    }

    $sql = "SELECT c.cart_id, p.name, p.price, c.quantity 
            FROM cart c 
            JOIN products_data p ON c.id = p.id 
            WHERE c.userID = '$userID'";

    $query = mysqli_query($conn, $sql); 

?>
    <div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div>
    
    <?php 
            // if (mysqli_num_rows($query) > 0) { ?>
            <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
                <div class="offcanvas-header justify-content-center">
                    <h5 class="offcanvas-title">Your Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <div class="order-md-last">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">سلة التسوق</span>
                            <span class="badge bg-primary rounded-pill">
                                <?php echo countItems("userID", "cart", "$userID"); ?>
                            </span>
                        </h4>
                        <ul class="list-group mb-3">
                            <?php
                              if (mysqli_num_rows($query) > 0) {

                            $total = 0;
                            while ($cart = mysqli_fetch_assoc($query)) { 
                                $itemTotal = $cart['price'] * $cart['quantity'];
                                $total += $itemTotal;
                            ?>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0"><?php echo $cart['name']; ?></h6>
                                    <small class="text-muted">Quantity: <?php echo $cart['quantity']; ?></small>
                                </div>
                                <span class="text-muted"><?php echo $itemTotal; ?> EGP</span>
                            </li>
                            <?php } ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (EGP)</span>
                                <strong><?php echo $total; ?> EGP</strong>
                            </li>
                        </ul>
                        <?php } else {
                                echo '<p class="text-dark text-center">' . "Cart is Empty.." . '</p>';
                        } ?>
                        
            <a href="check_out.php" class="btn btn-warning w-100 my-4 <?php echo (mysqli_num_rows($query) == 0) ? 'disabled' : ''; ?>">
                Proceed to Checkout
            </a>

                    </div>
                </div>
            </div>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch" aria-labelledby="Search">
      <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">ابحث</span>
          </h4>
          <form role="search" action="index.php" method="get" class="d-flex mt-3 gap-0">
            <input class="form-control rounded-start rounded-0 bg-light" type="email" placeholder="بتدور على ايه؟" aria-label="بتدور على ايه؟">
            <button class="btn btn-dark rounded-end rounded-0" type="submit">ابحث</button>
          </form>
        </div>
      </div>
    </div>

    <header>
      <div class="container-fluid">
        <div class="row py-3 border-bottom">
          
          <div class="col-sm-4 col-lg-3 text-center text-sm-start">
            <div class="main-logo">
              <a href="index.php" class="text-decoration-none d-flex align-items-center">
                <img src="../user/images/logo3.jpg" alt="YAZAN ONLINE SHOP" style="height: 60px; width: 60px; margin-right: 10px;">
                <div>
                  <h3 style="color:#26415E; margin: 0;">YAZAN | يزن</h3>
                  <h5 style="color:#274D60; margin: 0;">ONLINE SHOP</h5>
                </div>
              </a>
            </div>
          </div>
          
          <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block">
            <div class="search-bar row bg-light p-2 my-2 rounded-4">
              <div class="col-md-4 d-none d-md-block">
                <?php 
                  $query = mysqli_query($conn, "SELECT category_id, category_name FROM categories_data");
                  if (!$query) {
                      echo "Error in Query: " . mysqli_error($conn);
                      exit;
                  }
                ?>
                <select class="form-select border-0 bg-transparent">
                  <option>الفئات</option>
                  <?php  
                    while ($category = mysqli_fetch_assoc($query)) {  
                  ?>
                      <option value="<?php echo $category['category_id']; ?>">
                        <?php echo htmlspecialchars($category['category_name']); ?>
                      </option>
                  <?php  
                    } 
                  ?>
                </select>
              </div>
              
              <div class="col-11 col-md-7">
                <form id="search-form" class="text-center" action="index.php" method="post">
                  <input type="text" class="form-control border-0 bg-transparent" placeholder="بتدور على ايه؟" />
                </form>
              </div>

              <div class="col-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z"/>
                </svg>
              </div>
            </div>
          </div>
          
          <div class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
            <div class="support-box text-end d-none d-xl-block">
              <span class="fs-6 text-muted">تواصل؟</span>
              <a href="https://wa.me/201119842314?text=احتاج%20للمساعدة" target="_blank">
                  <img src="https://img.icons8.com/color/48/000000/whatsapp.png" alt="WhatsApp Icon" style="width: 30px; height: 30px;"/>
              </a>
            </div>

            <ul class="d-flex justify-content-end list-unstyled m-0">
              <li>
                <a href="userInfo.php" class="rounded-circle bg-light p-2 mx-1">
                  <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#user"></use></svg>
                </a>
              </li>
              <li>
                <a href="#" class="rounded-circle bg-light p-2 mx-1">
                  <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#heart"></use></svg>
                </a>
              </li>
              <li class="d-lg-none">
                <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                  <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#cart"></use></svg>
                </a>
              </li>
              <li class="d-lg-none">
                <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                  <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#search"></use></svg>
                </a>
              </li>
            </ul>

            <div class="cart text-end d-none d-lg-block dropdown">
              <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                <span class="fs-6 text-muted dropdown-toggle">عربة التسوق <?php  echo countItems("userID", "cart","$userID") ?></span>
              </button>
            </div>
          </div>

        </div>
      </div>


<div class="container-fluid">
    <div class="row py-2">
        <div class="d-flex justify-content-center justify-content-sm-between align-items-center">
            <nav class="main-menu d-flex navbar navbar-expand-lg">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header justify-content-center">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 align-items-center mb-0">
                            <!-- Dropdown for Categories -->
                            <li class="nav-item dropdown">
                                <?php 
                                    $query = mysqli_query($conn, "SELECT category_id, category_name FROM categories_data");
                                    if (!$query || mysqli_num_rows($query) == 0) {
                                        echo "<p class='text-muted'>لا توجد فئات متاحة</p>";
                                    } else {
                                ?>
                                <select id="categorySelect" class="form-select border-0 bg-light" style="width: auto;">
                                    <option selected disabled>اختر فئة</option>
                                    <?php while ($category = mysqli_fetch_assoc($query)) { ?>
                                        <option value="<?php echo $category['category_id']; ?>">
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <script> //بوجة اليوزر لصفحة الكاتيجورى لعرض منتجاتها
                                    document.getElementById('categorySelect').addEventListener('change', function() {
                                        const categoryId = this.value;
                                        if (categoryId) {
                                            window.location.href = `category.php?id=${categoryId}`;
                                        }
                                    });
                                </script>
                                <?php } ?>
                            </li>
                            
                            <!-- Shopping Cart -->
                            <li class="nav-item active">
                                <a href="cart.php" class="nav-link">
                                    عربة التسوق<span class="badge bg-primary rounded-pill text-center"><?php echo countItems("userID", "cart", "$userID") ?></span>
                                </a>
                            </li>

                            <!-- Orders -->
                            <li class="nav-item dropdown">
                                <a href="orders.php" class="nav-link">طلباتي</a>
                            </li>

                            <!-- Other Links -->
                            <!-- <li class="nav-item">
                                <a href="#kids" class="nav-link">أطفال</a>
                            </li>
                            <li class="nav-item">
                                <a href="#accessories" class="nav-link">اكسسوارات</a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
