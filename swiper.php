<?php
require 'config/connection.php';
$products_query = mysqli_query($conn, "SELECT * FROM products_data LIMIT 15");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- bootstarp -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
</head>

<body>

    <div style="padding-block: 24px; background-color: rgb(255, 255, 255);">
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 px-3 pb-4">
                            <div class=" d-flex  align-items-center justify-content-between">
                                <div class="d-flex align-items-center"><img srcset="/_next/static/media/discounted_products.bbe8cd65.svg" alt="" class="">
                                    <h6 class="mx-2" style="font-size: 18px; font-weight: 700;">اجمد الخصومات</h6>
                                </div>
                                <div class="buttonWidthController">
                                    <div style="width: 100%; padding-block: 5%; padding-inline: 5%;"><button class="kenzz-button" style="background-color: rgb(126, 0, 225); color: rgb(255, 255, 255); height: 55px; width: 100%; border-radius: 10px; border-width: 1px; border-style: solid; border-color: transparent; display: flex; flex-direction: row; justify-content: center; align-items: center; font-weight: 700; opacity: 1; box-shadow: rgb(63, 2, 121) 0px 3px;">
                                            <div style="white-space: nowrap;">شوف كل المنتجات</div>
                                        </button></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="infinite-scroll-component__outerdiv">
                                <div class="infinite-scroll-component row flex-nowrap pb-3" style="height: auto; overflow: auto;">
                                    <?php
                                    while ($product = mysqli_fetch_assoc($products_query)) {
                                        $discount = (round($product['old_price'] - $product['price']) / $product['old_price']) * 100;
                                    ?>

                                        <div class="col-md-3 col-3" style="margin: 0px 6px; min-width: 150px;"><a href="/product/XG663RR3QGRG/%D8%A3%D8%AC%D8%A7-%D8%B9%D8%B5%D9%8A%D8%B1-%D8%A8%D8%B1%D8%AA%D9%82%D8%A7%D9%84-320-%D9%85%D9%84%D9%84%D9%8A" style="text-decoration: none;">
                                                <div style="width: 100%;">
                                                    <div style="border-width: 0.5px; border-color: rgb(241, 241, 241); border-radius: 10px; background: rgb(249, 249, 249); box-shadow: rgba(0, 0, 0, 0.08) 0px 2px 4px;">
                                                        <div style="border-radius: 10px; display: flex; align-items: center; justify-content: center; position: relative; padding-top: 10px;">
                                                            <div class="season-tag-responsive-handling"><a href="/tag/5TLUAQZSQKC7/%D8%A7%D8%B7%D9%84%D8%A8%D8%AA-%D9%83%D8%AA%D9%8A%D8%B1" style="top: 5%; right: 3%; background-color: rgb(238, 17, 17); border-radius: 4px; padding: 2%; position: absolute; text-decoration: none;">
                                                                    <div style="
    font-family: Almarai, sans-serif; 
    font-size: 12px; 
    font-weight: 600; 
    color: #ffffff; 
    border-radius: 5px; 
    padding: 1px 4px; 
    display: inline-block; 
    text-align: center;">
                                                                        <?php echo number_format($discount, 1); ?>%
                                                                    </div>
                                                                </a></div><img src="uploads/img/<?php echo $product['image'] ?>" alt="" class="" style="height: 14vh; width: 95%; background-color: rgb(255, 255, 255); object-fit: scale-down; background-position: center center; background-size: contain;">
                                                        </div>
                                                        <div style="flex-direction: row; width: 100%; padding: 5%; justify-content: flex-start;">
                                                            <div style="width: 100%; align-items: flex-start; position: relative;">
                                                                <div class="product-card-grid_brandIconContainer__gqL5w">
                                                                    <div class="product-card-grid_discountContainer__dQkoX">
                                                                        <p><?php echo number_format($discount, 1) ?>%</p>
                                                                    </div>
                                                                </div>
                                                                <p style="font-size: 16px; font-weight: 400; color: rgb(32, 32, 32); height: 3em; line-height: 1.5em; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical"><?php echo $product['name'] ?></p>
                                                                <div style="flex-direction: row; width: 100%;">
                                                                    <div>
                                                                        <div class="product-card-grid_ratingAndMarketPriceContainer__QT9gD">
                                                                            <div style="flex-direction: row; margin-top: 2%; text-decoration-color: rgb(161, 161, 161); width: 25%;">
                                                                                <div style="flex-direction: row; display: flex; color: rgb(161, 161, 161); align-items: center; position: relative;">
                                                                                    <div style="width: 100%; height: 1.5px; position: absolute; background-color: rgb(161, 161, 161);"></div>
                                                                                    <del style="font-size: 18px; font-weight: 500; margin-inline: 3%;"><?php echo $product['old_price'] ?></del><span style="font-size: 12px;">ج.م</span>
                                                                                </div>
                                                                            </div>
                                                                            <!-- <div class="product-card-grid_ratingContainer__YlYKS">
                                                                                <p><span style="color: rgb(125, 125, 125);">(13)</span> <span style="color: rgb(0, 0, 0);">3.9</span></p><img src="/_next/static/media/rating.icon.1c7dabf3.svg" width="16" alt="rating" class="">
                                                                            </div> -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-card-grid_priceAndTagContainer__NHVnD">
                                                                        <div>
                                                                            <div style="flex-direction: row; display: flex; color: black; align-items: center; position: relative;">
                                                                                <div style="width: 100%; height: 0px; position: absolute;"></div>
                                                                                <p style="font-size: 18px; font-weight: bold; margin-inline: 3%; color:red;"><?php echo $product['price'] ?></p><span style="font-size: 12px;">ج.م</span>
                                                                            </div>
                                                                        </div>
                                                                        <div style="position: relative; margin-inline: 2%;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-3 col-3" style="margin: 0px 6px; min-width: 150px;"><a href="/product/FQWP7DGAC69R/%D8%A3%D8%AC%D8%A7-%D8%B9%D8%B5%D9%8A%D8%B1-%D8%B9%D9%86%D8%A8-320-%D9%85%D9%84%D9%84%D9%8A" style="text-decoration: none;">
                                            <div style="width: 100%;">
                                                <div style="border-width: 0.5px; border-color: rgb(241, 241, 241); border-radius: 10px; background: rgb(249, 249, 249); box-shadow: rgba(0, 0, 0, 0.08) 0px 2px 4px;">
                                                    <div style="border-radius: 10px; display: flex; align-items: center; justify-content: center; position: relative; padding-top: 10px;">
                                                        <div class="season-tag-responsive-handling"><a href="/tag/5TLUAQZSQKC7/%D8%A7%D8%B7%D9%84%D8%A8%D8%AA-%D9%83%D8%AA%D9%8A%D8%B1" style="top: 5%; right: 3%; background-color: rgb(238, 17, 17); border-radius: 4px; padding: 2%; position: absolute; text-decoration: none;">
                                                                <p style="font-family: Almarai; font-style: normal; font-weight: 700; font-size: 12px; line-height: 13px; display: flex; align-items: center; color: rgb(255, 255, 255);">اطلبت كتير</p>
                                                            </a></div><img src="https://assets.kenzz.com/processed/261890/aga-6221055006418_1200.webp" alt="أجا عصير عنب - 320 مللي" class="" style="height: 14vh; width: 95%; background-color: rgb(255, 255, 255); object-fit: scale-down; background-position: center center; background-size: contain;">
                                                    </div>
                                                    <div style="flex-direction: row; width: 100%; padding: 5%; justify-content: flex-start;">
                                                        <div style="width: 100%; align-items: flex-start; position: relative;">
                                                            <div class="product-card-grid_brandIconContainer__gqL5w"></div>
                                                            <div class="product-card-grid_firstLineContainer__4U6oq">
                                                                <div class="product-card-grid_discountContainer__dQkoX">
                                                                    <p>24%-</p>
                                                                </div>
                                                            </div>
                                                            <p style="font-size: 16px; font-weight: 400; color: rgb(32, 32, 32); height: 3em; line-height: 1.5em; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">أجا عصير عنب - 320 مللي</p>
                                                            <div style="flex-direction: row; width: 100%;">
                                                                <div>
                                                                    <div class="product-card-grid_ratingAndMarketPriceContainer__QT9gD">
                                                                        <div style="flex-direction: row; margin-top: 2%; text-decoration-color: rgb(161, 161, 161); width: 25%;">
                                                                            <div style="flex-direction: row; display: flex; color: rgb(161, 161, 161); align-items: center; position: relative;">
                                                                                <div style="width: 100%; height: 1.5px; position: absolute; background-color: rgb(161, 161, 161);"></div>
                                                                                <p style="font-size: 18px; font-weight: 500; margin-inline: 3%;">25</p><span style="font-size: 12px;">ج.م</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-card-grid_ratingContainer__YlYKS">
                                                                            <p><span style="color: rgb(125, 125, 125);">(17)</span> <span style="color: rgb(0, 0, 0);">4.5</span></p><img src="/_next/static/media/rating.icon.1c7dabf3.svg" width="16" alt="rating" class="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-card-grid_priceAndTagContainer__NHVnD">
                                                                    <div>
                                                                        <div style="flex-direction: row; display: flex; color: black; align-items: center; position: relative;">
                                                                            <div style="width: 100%; height: 0px; position: absolute;"></div>
                                                                            <p style="font-size: 24px; font-weight: bold; margin-inline: 3%;">19</p><span style="font-size: 12px;">ج.م</span>
                                                                        </div>
                                                                    </div>
                                                                    <div style="position: relative; margin-inline: 2%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a></div>
                                    <div class="col-md-3 col-3" style="margin: 0px 6px; min-width: 150px;"><a href="/product/JC3N2A972BT9/%D8%B3%D9%85%D8%A7%D8%B9%D8%A9-%D8%B5%D8%A8-%D9%85%D9%8A%D9%86%D9%89" style="text-decoration: none;">
                                            <div style="width: 100%;">
                                                <div style="border-width: 0.5px; border-color: rgb(241, 241, 241); border-radius: 10px; background: rgb(249, 249, 249); box-shadow: rgba(0, 0, 0, 0.08) 0px 2px 4px;">
                                                    <div style="border-radius: 10px; display: flex; align-items: center; justify-content: center; position: relative; padding-top: 10px;">
                                                        <div class="season-tag-responsive-handling"><a href="/tag/5TLUAQZSQKC7/%D8%A7%D8%B7%D9%84%D8%A8%D8%AA-%D9%83%D8%AA%D9%8A%D8%B1" style="top: 5%; right: 3%; background-color: rgb(238, 17, 17); border-radius: 4px; padding: 2%; position: absolute; text-decoration: none;">
                                                                <p style="font-family: Almarai; font-style: normal; font-weight: 700; font-size: 12px; line-height: 13px; display: flex; align-items: center; color: rgb(255, 255, 255);">اطلبت كتير</p>
                                                                </a></div><img src="https://assets.kenzz.com/processed/39/CK-132_1200.webp" alt="سماعة صب مينى" class="" style="height: 14vh; width: 95%; background-color: rgb(255, 255, 255); object-fit: scale-down; background-position: center center; background-size: contain;">
                                                        </div>
                                                        <div style="flex-direction: row; width: 100%; padding: 5%; justify-content: flex-start;">
                                                            <div style="width: 100%; align-items: flex-start; position: relative;">
                                                                <div class="product-card-grid_firstLineContainer__4U6oq">
                                                                    <div class="product-card-grid_discountContainer__dQkoX">
                                                                        <p>29%-</p>
                                                                    </div>
                                                                </div>
                                                                <p style="font-size: 16px; font-weight: 400; color: rgb(32, 32, 32); height: 3em; line-height: 1.5em; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">سماعة صب مينى بلوتوث</p>
                                                                <div style="flex-direction: row; width: 100%;">
                                                                    <div>
                                                                        <div class="product-card-grid_ratingAndMarketPriceContainer__QT9gD">
                                                                            <div style="flex-direction: row; margin-top: 2%; text-decoration-color: rgb(161, 161, 161); width: 25%;">
                                                                                <div style="flex-direction: row; display: flex; color: rgb(161, 161, 161); align-items: center; position: relative;">
                                                                                    <div style="width: 100%; height: 1.5px; position: absolute; background-color: rgb(161, 161, 161);"></div>
                                                                                    <p style="font-size: 18px; font-weight: 500; margin-inline: 3%;">294</p><span style="font-size: 12px;">ج.م</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-card-grid_ratingContainer__YlYKS">
                                                                                <p><span style="color: rgb(125, 125, 125);">(14)</span> <span style="color: rgb(0, 0, 0);">3.3</span></p><img src="/_next/static/media/rating.icon.1c7dabf3.svg" width="16" alt="rating" class="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-card-grid_priceAndTagContainer__NHVnD">
                                                                        <div>
                                                                            <div style="flex-direction: row; display: flex; color: black; align-items: center; position: relative;">
                                                                                <div style="width: 100%; height: 0px; position: absolute;"></div>
                                                                                <p style="font-size: 24px; font-weight: bold; margin-inline: 3%;">209</p><span style="font-size: 12px;">ج.م</span>
                                                                            </div>
                                                                        </div>
                                                                        <div style="position: relative; margin-inline: 2%;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </a></div>
                                    <div class="col-md-3 col-3" style="margin: 0px 6px; min-width: 150px;"><a href="/product/N5LVAV8Y5T27/%D8%A8%D9%88%D9%83%D8%B3%D8%B1-%D8%B1%D8%AC%D8%A7%D9%84%D9%8A-%D8%B3%D8%A7%D8%AF%D8%A9-6-%D9%82%D8%B7%D8%B9" style="text-decoration: none;">
                                            <div style="width: 100%;">
                                                <div style="border-width: 0.5px; border-color: rgb(241, 241, 241); border-radius: 10px; background: rgb(249, 249, 249); box-shadow: rgba(0, 0, 0, 0.08) 0px 2px 4px;">
                                                    <div style="border-radius: 10px; display: flex; align-items: center; justify-content: center; position: relative; padding-top: 10px;">
                                                        <div class="season-tag-responsive-handling"><a href="/tag/5TLUAQZSQKC7/%D8%A7%D8%B7%D9%84%D8%A8%D8%AA-%D9%83%D8%AA%D9%8A%D8%B1" style="top: 5%; right: 3%; background-color: rgb(238, 17, 17); border-radius: 4px; padding: 2%; position: absolute; text-decoration: none;">
                                                                <p style="font-family: Almarai; font-style: normal; font-weight: 700; font-size: 12px; line-height: 13px; display: flex; align-items: center; color: rgb(255, 255, 255);">اطلبت كتير</p>
                                                            </a></div><img src="https://assets.kenzz.com/processed/175865/qasas-366_1200.webp" alt="بوكسر رجالي سادة - 6 قطع" class="" style="height: 14vh; width: 95%; background-color: rgb(255, 255, 255); object-fit: scale-down; background-position: center center; background-size: contain;">
                                                    </div>
                                                    <div style="flex-direction: row; width: 100%; padding: 5%; justify-content: flex-start;">
                                                        <div style="width: 100%; align-items: flex-start; position: relative;">
                                                            <div class="product-card-grid_firstLineContainer__4U6oq">
                                                                <div class="product-card-grid_discountContainer__dQkoX">
                                                                    <p>35%-</p>
                                                                </div>
                                                            </div>
                                                            <p style="font-size: 16px; font-weight: 400; color: rgb(32, 32, 32); height: 3em; line-height: 1.5em; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">بوكسر رجالي سادة - 6 قطع</p>
                                                            <div style="flex-direction: row; width: 100%;">
                                                                <div>
                                                                    <div class="product-card-grid_ratingAndMarketPriceContainer__QT9gD">
                                                                        <div style="flex-direction: row; margin-top: 2%; text-decoration-color: rgb(161, 161, 161); width: 25%;">
                                                                            <div style="flex-direction: row; display: flex; color: rgb(161, 161, 161); align-items: center; position: relative;">
                                                                                <div style="width: 100%; height: 1.5px; position: absolute; background-color: rgb(161, 161, 161);"></div>
                                                                                <p style="font-size: 18px; font-weight: 500; margin-inline: 3%;">549</p><span style="font-size: 12px;">ج.م</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-card-grid_ratingContainer__YlYKS">
                                                                            <p><span style="color: rgb(125, 125, 125);">(17)</span> <span style="color: rgb(0, 0, 0);">4.0</span></p><img src="/_next/static/media/rating.icon.1c7dabf3.svg" width="16" alt="rating" class="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-card-grid_priceAndTagContainer__NHVnD">
                                                                    <div>
                                                                        <div style="flex-direction: row; display: flex; color: black; align-items: center; position: relative;">
                                                                            <div style="width: 100%; height: 0px; position: absolute;"></div>
                                                                            <p style="font-size: 24px; font-weight: bold; margin-inline: 3%;">355</p><span style="font-size: 12px;">ج.م</span>
                                                                        </div>
                                                                    </div>
                                                                    <div style="position: relative; margin-inline: 2%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a></div>
                                    <div class="col-md-3 col-3" style="margin: 0px 6px; min-width: 150px;"><a href="/product/53FV7G8XJSDE/%D8%A3%D8%AC%D8%A7-%D8%B9%D8%B5%D9%8A%D8%B1-%D8%AA%D9%81%D8%A7%D8%AD-320-%D9%85%D9%84%D9%84%D9%8A" style="text-decoration: none;">
                                            <div style="width: 100%;">
                                                <div style="border-width: 0.5px; border-color: rgb(241, 241, 241); border-radius: 10px; background: rgb(249, 249, 249); box-shadow: rgba(0, 0, 0, 0.08) 0px 2px 4px;">
                                                    <div style="border-radius: 10px; display: flex; align-items: center; justify-content: center; position: relative; padding-top: 10px;">
                                                        <div class="season-tag-responsive-handling"><a href="/tag/5TLUAQZSQKC7/%D8%A7%D8%B7%D9%84%D8%A8%D8%AA-%D9%83%D8%AA%D9%8A%D8%B1" style="top: 5%; right: 3%; background-color: rgb(238, 17, 17); border-radius: 4px; padding: 2%; position: absolute; text-decoration: none;">
                                                                <p style="font-family: Almarai; font-style: normal; font-weight: 700; font-size: 12px; line-height: 13px; display: flex; align-items: center; color: rgb(255, 255, 255);">اطلبت كتير</p>
                                                            </a></div><img src="https://assets.kenzz.com/processed/261890/aga-6221055006210_1200.webp" alt="أجا عصير تفاح - 320 مللي" class="" style="height: 14vh; width: 95%; background-color: rgb(255, 255, 255); object-fit: scale-down; background-position: center center; background-size: contain;">
                                                    </div>
                                                    <div style="flex-direction: row; width: 100%; padding: 5%; justify-content: flex-start;">
                                                        <div style="width: 100%; align-items: flex-start; position: relative;">
                                                            <d class="product-card-grid_brandIconContainer__gqL5w">
                                                            <div class="product-card-grid_firstLineContainer__4U6oq">
                                                                <div class="product-card-grid_discountContainer__dQkoX">
                                                                    <p>24%-</p>
                                                                </div>
                                                            </div>
                                                            <p style="font-size: 16px; font-weight: 400; color: rgb(32, 32, 32); height: 3em; line-height: 1.5em; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">أجا عصير تفاح - 320 مللي</p>
                                                            <div style="flex-direction: row; width: 100%;">
                                                                <div>
                                                                    <div class="product-card-grid_ratingAndMarketPriceContainer__QT9gD">
                                                                        <div style="flex-direction: row; margin-top: 2%; text-decoration-color: rgb(161, 161, 161); width: 25%;">
                                                                            <div style="flex-direction: row; display: flex; color: rgb(161, 161, 161); align-items: center; position: relative;">
                                                                                <div style="width: 100%; height: 1.5px; position: absolute; background-color: rgb(161, 161, 161);"></div>
                                                                                <p style="font-size: 18px; font-weight: 500; margin-inline: 3%;">25</p><span style="font-size: 12px;">ج.م</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-card-grid_ratingContainer__YlYKS">
                                                                            <p><span style="color: rgb(125, 125, 125);">(12)</span> <span style="color: rgb(0, 0, 0);">4.2</span></p><img src="/_next/static/media/rating.icon.1c7dabf3.svg" width="16" alt="rating" class="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-card-grid_priceAndTagContainer__NHVnD">
                                                                    <div>
                                                                        <div style="flex-direction: row; display: flex; color: black; align-items: center; position: relative;">
                                                                            <div style="width: 100%; height: 0px; position: absolute;"></div>
                                                                            <p style="font-size: 24px; font-weight: bold; margin-inline: 3%;">19</p><span style="font-size: 12px;">ج.م</span>
                                                                        </div>
                                                                    </div>
                                                                    <div style="position: relative; margin-inline: 2%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a></div>
                                    <div class="col-md-3 col-3" style="margin: 0px 6px; min-width: 150px;"><a href="/product/SP4ZMGGUWE4Z/%D9%81%D8%A7%D9%86%D9%84%D8%A9-%D8%AD%D9%85%D8%A7%D9%84%D9%87-%D8%B1%D8%AC%D8%A7%D9%84%D9%8A-%D9%82%D8%B7%D9%86-3-%D9%82%D8%B7%D8%B9" style="text-decoration: none;">
                                            <div style="width: 100%;">
                                                <div style="border-width: 0.5px; border-color: rgb(241, 241, 241); border-radius: 10px; background: rgb(249, 249, 249); box-shadow: rgba(0, 0, 0, 0.08) 0px 2px 4px;">
                                                    <div style="border-radius: 10px; display: flex; align-items: center; justify-content: center; position: relative; padding-top: 10px;">
                                                        <div class="season-tag-responsive-handling"><a href="/tag/5TLUAQZSQKC7/%D8%A7%D8%B7%D9%84%D8%A8%D8%AA-%D9%83%D8%AA%D9%8A%D8%B1" style="top: 5%; right: 3%; background-color: rgb(238, 17, 17); border-radius: 4px; padding: 2%; position: absolute; text-decoration: none;">
                                                                <p style="font-family: Almarai; font-style: normal; font-weight: 700; font-size: 12px; line-height: 13px; display: flex; align-items: center; color: rgb(255, 255, 255);">اطلبت كتير</p>
                                                            </a></div><img src="https://assets.kenzz.com/processed/20785/Relax-534_1200.webp" alt="فانلة حماله رجالي قطن - 3 قطع" class="" style="height: 14vh; width: 95%; background-color: rgb(255, 255, 255); object-fit: scale-down; background-position: center center; background-size: contain;">
                                                    </div>
                                                    <div style="flex-direction: row; width: 100%; padding: 5%; justify-content: flex-start;">
                                                        <div style="width: 100%; align-items: flex-start; position: relative;">
                                                            <div class="product-card-grid_brandIconContainer__gqL5w"></div>
                                                            <div class="product-card-grid_firstLineContainer__4U6oq">
                                                                <div class="product-card-grid_discountContainer__dQkoX">
                                                                    <p>44%-</p>
                                                                </div>
                                                            </div>
                                                            <p style="font-size: 16px; font-weight: 400; color: rgb(32, 32, 32); height: 3em; line-height: 1.5em; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">فانلة حماله رجالي قطن - 3 قطع</p>
                                                            <div style="flex-direction: row; width: 100%;">
                                                                <div>
                                                                    <div class="product-card-grid_ratingAndMarketPriceContainer__QT9gD">
                                                                        <div style="flex-direction: row; margin-top: 2%; text-decoration-color: rgb(161, 161, 161); width: 25%;">
                                                                            <div style="flex-direction: row; display: flex; color: rgb(161, 161, 161); align-items: center; position: relative;">
                                                                                <div style="width: 100%; height: 1.5px; position: absolute; background-color: rgb(161, 161, 161);"></div>
                                                                                <p style="font-size: 18px; font-weight: 500; margin-inline: 3%;">425</p><span style="font-size: 12px;">ج.م</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-card-grid_ratingContainer__YlYKS">
                                                                            <p><span style="color: rgb(125, 125, 125);">(44)</span> <span style="color: rgb(0, 0, 0);">4.6</span></p><img src="/_next/static/media/rating.icon.1c7dabf3.svg" width="16" alt="rating" class="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-card-grid_priceAndTagContainer__NHVnD">
                                                                    <div>
                                                                        <div style="flex-direction: row; display: flex; color: black; align-items: center; position: relative;">
                                                                            <div style="width: 100%; height: 0px; position: absolute;"></div>
                                                                            <p style="font-size: 24px; font-weight: bold; margin-inline: 3%;">240</p><span style="font-size: 12px;">ج.م</span>
                                                                        </div>
                                                                    </div>
                                                                    <div style="position: relative; margin-inline: 2%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a></div> -->
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<div class="inActiveTabBorderBottom" style="width: 100%; display: flex; flex: 0 0 auto; justify-content: space-between; bottom: 0px; z-index: 2; height: 65px; background-color: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 4px; cursor: pointer;">
    <div class="" style="width: 33%; height: 65px; display: flex; align-items: center; justify-content: center;"><img id="tab-nav-search" src="/_next/static/media/search_icon.5a636dbf.svg" width="32" height="24" alt="search_button" class=""></div>
    <div class="" style="width: 33%; height: 65px; display: flex; align-items: center; justify-content: center; position: relative;"><img id="tab-nav-order" src="/_next/static/media/orderIcon.868a65da.svg" width="32" height="32" alt="orders_button" class=""></div>
    <div class="activeTabBorderBottom" style="width: 33%; height: 65px; display: flex; align-items: center; justify-content: center;"><img id="tab-nav-home" src="/_next/static/media/homeIconActive.0ac18a83.svg" width="32" height="24" alt="home_button" class=""></div>
    <div class="" style="width: 33%; height: 65px; display: flex; align-items: center; justify-content: center;"><img id="tab-nav-profile" src="/_next/static/media/profileIcon.e602cfef.svg" width="32" height="24" alt="profile_button" class=""></div>
</div>

</html>