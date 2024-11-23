<?php
    // session_start();
    require '../config/connection.php';
    require '../config/functions.php';
    require 'assets/header.php';
    $pageTitle = 'YAZAN | عملية اتمام طلب منتج';
    $user_id = $_SESSION['userID'];
?>

<title><?php echo getTitle($pageTitle); ?></title>
        


<!-- <!DOCTYPE html>
  <html lang="ar" dir="rtl">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>صفحة الدفع</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head> -->
  <body>
    <div class="container my-5">
        <h2 class="text-center mb-4">إتمام الطلب</h2>
        <div class="row">
            <!-- تفاصيل الدفع -->
            <div class="col-lg-8">
                <div class="card p-4 mb-4">
                    <h4 class="mb-3">معلومات الشحن</h4>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fullName" class="form-label">الاسم الكامل</label>
                                <input type="text" id="fullName" class="form-control" placeholder="أدخل اسمك الكامل">
                            </div>
                            <div class="col-md-6">
                                <label for="phoneNumber" class="form-label">رقم الهاتف</label>
                                <input type="tel" id="phoneNumber" class="form-control" placeholder="أدخل رقم هاتفك">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">العنوان</label>
                            <input type="text" id="address" class="form-control" placeholder="أدخل عنوانك الكامل">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="city" class="form-label">المدينة</label>
                                <select id="city" class="form-select">
                                    <option value="sikka">سلكا</option>
                                    <option value="baheera">بحقيرة</option>
                                    <option value="hawawsha">الحواوشة</option>
                                    <option value="naqeeta">نقيطة</option>
                                    <option value="nosa">نوسا</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="zipCode" class="form-label">الرمز البريدي</label>
                                <input type="text" id="zipCode" class="form-control" placeholder="أدخل الرمز البريدي">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card p-4">
                    <h4 class="mb-3">طريقة الدفع</h4>
                    <form>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
                            <label class="form-check-label" for="creditCard">
                                بطاقة ائتمان
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="paypal">
                            <label class="form-check-label" for="paypal">
                                باي بال
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="cash">
                            <label class="form-check-label" for="cash">
                                الدفع عند الاستلام
                            </label>
                        </div>
                    </form>
                </div>
            </div>
<?php
      $result = mysqli_query($conn, "SELECT * FROM cart WHERE userID = '$user_id' ");
      if($result && mysqli_num_rows($result) > 0) {
          // $cart_item = mysqli_fetch_assoc($result);
      } else {
        echo 'ERROR';
      }

?>
            <!-- ملخص الطلب -->
              <div class="col-lg-4">
                  <div class="card p-4">
                      <h4 class="mb-3">ملخص الطلب</h4>
                      <table class="table">
                          <thead>
                              <tr>
                                  <th scope="col">اسم المنتج</th>
                                  <th scope="col">الكمية</th>
                                  <th scope="col">السعر</th>
                                  <th scope="col">الإجمالي</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php
                            $total_price = 0;
                                  while($cart_item = mysqli_fetch_assoc($result)) { 
                                    $item_total =  $cart_item['quantity'] * $cart_item['product_price'];
                                    $total_price += $item_total;
                                      echo ' 
                                      <tr>
                                          <td>' . $cart_item['product_name'] . '</td>
                                          <td>' . $cart_item['quantity'] . '</td>
                                          <td>' . $cart_item['product_price'] . '</td>
                                          <td>' . $item_total . '</td>
                                      </tr>
                                      ';
                                  }
                              ?>
                          </tbody>
                      </table>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                            الإجمالي <strong><?php echo $total_price ?></strong>
                        </li>
                      <button class="btn btn-success w-100">إتمام الطلب</button>
                  </div>
              </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php  require 'assets/footer.php'; ?>

  <!-- Bootstrap JS -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> -->
