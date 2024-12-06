








$(".add-to-cart").click(function () {
  var product_id = $(this).data("id");
  var product_name = $(this).data("name");
  var product_price = $(this).data("price");
  var product_image = $(this).data("image");

  // الحصول على قيمة الكمية من حقل الكمية
  var quantity = $("#quantity").val(); // التأكد من أخذ الكمية من حقل الإدخال

  $.ajax({
    url: "add_to_cart.php",
    type: "POST",
    data: {
      product_id: product_id,
      product_name: product_name,
      product_price: product_price,
      quantity: quantity, // إرسال الكمية المأخوذة من حقل الكمية
      product_image: product_image,
    },
    success: function (response) {
      $("#notification").fadeIn().delay(1000).fadeOut();
    },
    error: function () {
      alert("حدث خطأ أثناء إضافة المنتج إلى العربة.");
    },
  });
});


      // document
      //   .querySelectorAll(".quantity-left-minus, .quantity-right-plus")
      //   .forEach((button) => {
      //     button.addEventListener("click", function () {
      //       const type = this.dataset.type;
      //       const id = this.dataset.id;
      //       const input = document.getElementById(`quantity_${id}`);
      //       let value = parseInt(input.value);

      //       if (type === "minus" && value > 1) {
      //         value--;
      //       } else if (type === "plus") {
      //         value++;
      //       }

      //       input.value = value;
      //     });
      //   });





// $(".add-to-cart").click(function () {
//   var product_id = $(this).data("id");
//   var product_name = $(this).data("name");
//   var product_price = $(this).data("price");
//   var quantity = $(this).data("quantity");
//   var product_image = $(this).data("image");

//   $.ajax({
//     url: "add_to_cart.php",
//     type: "POST",
//     data: {
//       product_id: product_id,
//       product_name: product_name,
//       product_price: product_price,
//       quantity: quantity,
//       product_image: product_image,
//     },
//     success: function (response) {
//       $("#notification").fadeIn().delay(1000).fadeOut();
//     },
//     error: function () {
//       alert("حدث خطأ أثناء إضافة المنتج إلى العربة.");
//     },
//   });
// });

// $(".add_to_cart.php").click(function () {
//   var product_id = $(this).data("id");
//   var product_name = $(this).data("name");
//   var product_price = $(this).data("price");
//   var quantity = $(this).data("quantity");
//   var product_image = $(this).data("image");

//   $.ajax({
//     url: "add_to_cart.php",
//     type: "POST",
//     data: {
//       product_id: product_id,
//       product_name: product_name,
//       product_price: product_price,
//       quantity: quantity,
//       product_image: product_image,
//     },
//     success: function (response) {
//       $("#notification").fadeIn().delay(3000).fadeOut();
//     },
//     error: function () {
//       alert("حدث خطأ أثناء إضافة المنتج إلى العربة.");
//     },
//   });
// });

// ربط أزرار إضافة المنتج إلى العربة بالحدث
// document.querySelectorAll(".add-to-cart").forEach((button) => {
//   button.addEventListener("click", function () {
//     const productId = this.dataset.id;
//     const productName = this.dataset.name;
//     const productPrice = this.dataset.price;
//     const productImage = this.dataset.image;
//     const productQuantity = this.dataset.quantity || 1; // الكمية الافتراضية 1 إذا لم تكن موجودة

//     // إرسال الطلب إلى ملف PHP باستخدام Fetch
//     fetch("add_to_cart.php", {
//       method: "POST",
//       headers: {
//         "Content-Type": "application/x-www-form-urlencoded",
//       },
//       body: `product_id=${productId}&product_name=${encodeURIComponent(
//         productName
//       )}&product_price=${productPrice}&product_image=${encodeURIComponent(
//         productImage
//       )}&quantity=${productQuantity}`,
//     })
//       .then((response) => response.json()) // تحويل الرد إلى JSON
//       .then((data) => {
//         if (data.status === "success") {
//           // عرض Toast لإضافة ناجحة
//           Toastify({
//             text: `✅ تم إضافة "${productName}" (${productQuantity}) إلى العربة بنجاح!`,
//             duration: 3000,
//             close: true,
//             gravity: "top",
//             position: "right",
//             backgroundColor: "#4caf50",
//             stopOnFocus: true,
//             avatar: `../uploads/img/${productImage}`,
//           }).showToast();
//         } else {
//           // عرض Toast في حالة الخطأ
//           Toastify({
//             text: `❌ ${data.message}`,
//             duration: 3000,
//             close: true,
//             gravity: "top",
//             position: "right",
//             backgroundColor: "#f44336",
//             stopOnFocus: true,
//           }).showToast();
//         }
//       })
//       .catch((error) => {
//         // عرض Toast لخطأ في الشبكة
//         Toastify({
//           text: "❌ حدث خطأ في الشبكة. حاول لاحقًا.",
//           duration: 3000,
//           close: true,
//           gravity: "top",
//           position: "right",
//           backgroundColor: "#f44336",
//           stopOnFocus: true,
//         }).showToast();
//         console.error("Network Error:", error);
//       });
//   });
// });

// console.log(data);
