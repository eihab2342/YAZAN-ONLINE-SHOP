<?php
    session_start();
    require '../assets/header.php';
    require '../config/connection.php';
    require '../config/functions.php';

    if (!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != $_SERVER['HTTP_HOST']) {
        showAlerts(null, "You cannot reach this page directly", "../login.php");
        exit();
    }


    if(isset($_SESSION['userName']) && $_SESSION['role'] == 'admin') {
    require_once '../assets/sideBar.php';

    ?>
    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?php require_once '../assets/navBar.php'; 


    $result = mysqli_query($conn, "SELECT contact.msg_content, contact.created_at, users_data.userID, users_data.username, users_data.full_name , users_data.email FROM contact JOIN users_data ON contact.userID = users_data.userID");

    if (mysqli_num_rows($result) > 0) {

    ?>
    <div class="container text-center my-3">
        <!-- breadcrumb START -->
        <!-- <nav aria-label="breadcrumb" class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="contact.php">Contacts</a></li>
            </ol>
        </nav> -->
        <!-- breadcrumb END -->

        <h2 class="text-center">رسائل العملاء</h2>

        <div class="d-flex justify-content-center align-items-center my-3 table-responsive">
            <table class="table table-bordered table-hover mt-3 table-responsive" style="width: 100%; table-layout: fixed;">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 10%;">الرقم</th>
                        <th style="width: 25%;">اسم العميل</th>
                        <th style="width: 25%;">اسم المستخدم</th>
                        <th style="width: 35%;">البريد الإلكتروني</th>
                        <th style="width: 50%;">الرسالة</th>
                        <th style="width: 15%;">تاريخ الإرسال</th>
                        <th style="width: 15%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['userID']; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td style="word-wrap: break-word;"><?php echo $row['msg_content']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><a href="?do=delete" class="btn btn-danger">Delete</a></td>
                        <td><a href="?do="></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

        <?php  
            }

                $do = '';
                    if(isset($_GET['do'])) {
                        $do = $_GET['do'];
                    } else {
                        $do = 'total_users.php';
                    }

    if($do == 'delete') {
        
    }
        }
    require '../assets/footer.php';
?>
    </div>

