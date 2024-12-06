<?php
$result = mysqli_query($conn, "SELECT * from users_data");
if ($result) {
    $row = mysqli_fetch_assoc($result);
}
?>

<nav class="navbar navbar-expand bg-se navbar-light sticky-top px-4 py-0 bg-white">
    <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <!-- <form class="d-none d-md-flex ms-4">
        <input id="search-input" class="form-control  text-dark border-0" type="search" placeholder="Search" style="background-color: #ADEBAD;">
    </form> -->
    <!-- Start JQ Code To Serach  -->
    <script>
        $(document).ready(function() {
            $('#search-input').keyup(function() {
                var query = $(this).val();

                if (query.length > 1) { // إذا كان النص المدخل أطول من حرفين
                    $.ajax({
                        url: 'search.php', // الصفحة التي ستستقبل الاستعلامات
                        method: 'GET',
                        data: {
                            query: query
                        }, // إرسال النص المدخل في المتغير query
                        success: function(response) {
                            var results = JSON.parse(response); // تحويل الاستجابة إلى JSON
                            var resultsHtml = '';

                            // التحقق إذا كانت النتائج تحتوي على منتجات
                            if (results.length > 0) {
                                resultsHtml = '<ul class="list-unstyled">';

                                // عرض كل منتج في قائمة منسدلة (dropdown)
                                $.each(results, function(index, product) {
                                    resultsHtml += '<li><a href="product_details.php?product_id=' + product.id + '" class="dropdown-item">' + product.name + '</a></li>';
                                });
                                resultsHtml += '</ul>';
                            } else {
                                resultsHtml = '<p class="dropdown-item">لا توجد نتائج</p>';
                            }

                            // عرض النتائج في الـ div المخصص
                            $('#search-results').html(resultsHtml).addClass('show'); // إضافة class 'show' لعرض الـ dropdown
                        }
                    });
                } else {
                    $('#search-results').html('').removeClass('show'); // إخفاء النتائج إذا كان النص المدخل أقل من 3 حروف
                }
            });

            // إخفاء الـ dropdown عند النقر خارج الحقل
            $(document).click(function(e) {
                if (!$(e.target).closest('#search-input').length) {
                    $('#search-results').removeClass('show');
                }
            });
        });
    </script>
    <!-- End JQ Code To Serach  -->
    <div class="navbar-nav align-items-center ms-auto">
        <!-- Messages && Notifications -->
        <!-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div> -->
        <!-- Messages && Notifications -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="img/eihab.jpg" alt="" style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex"><?php echo $row['username'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-white border-0 rounded-0 rounded-bottom m-0">
                <a href="../user/userInfo.php" class="dropdown-item">My Profile</a>
                <a href="#" class="dropdown-item">Settings</a>
                <a href="../logout.php" class="dropdown-item">Log Out</a>
            </div>
        </div>
    </div>
</nav>