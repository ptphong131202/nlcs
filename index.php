<head>
    <title>Trang chủ</title>
</head>
<?php
	include('inc/header.php');
    include('inc/slider.php');
?>


<div class="row mt-3">
    <div class="col-12 text-center">
        <div>
            <h2>Sản phẩm khuyến mãi</h2>
            <p>Sản phẩm ấn tượng và bán nhiều ưu đãi nhất</p>
        </div>
    </div>
</div>
<div class="row">
    <?php
                $product_promotion = $product->getproduct_promotion();
                if($product_promotion) {
                    while($result_promotion = $product_promotion->fetch_assoc()) {
            ?>

    <div class="col-2 mb-4">
        <div class="card shadow-lg" style="height: 240px;">
            <a href="product-details.php?proid=<?php echo $result_promotion['productId']; ?>"><img height="150px"
                    width="100%" src="admin/uploads/<?php echo $result_promotion['image']; ?>" alt="First place"></a>
            <div class="card-body p-1">
                <h6><a class="text-decoration-none text-warning" href="#">
                        <p class="desc"><?php echo $result_promotion['productName']; ?></p>
                    </a></h6>
                <p class="current_price text-center py-0 m-0">
                    <?php echo $fm->format_currency($result_promotion['price']). " "."VND"; ?></p>
                <p class="text-decoration-line-through text-center py-0 m-0 price-last">
                    <?php echo $fm->format_currency($result_promotion['price']+$result_promotion['price']*0.07). " "."VND"; ?>
                </p>
            </div>
        </div>
    </div>

    <?php
                    }
                }
            ?>
</div>


<div class="row mt-3">
    <div class="col-12 text-center">
        <div>
            <h2>Sản phẩm vừa mới ra mắt </h2>
            <p>Sản phẩm vừa mới được ra mắt</p>
        </div>
    </div>
</div>
<div class="row">
    <?php
			$product_new = $product->getproduct_new();
			if($product_new) {
				while($result_new = $product_new->fetch_assoc()) {
		?>

    <div class="col-2 mb-4 ">
        <div class="card shadow-lg" style="height: 240px;">
            <a href="product-details.php?proid=<?php echo $result_new['productId']; ?>"><img height="150px" width="100%"
                    src="admin/uploads/<?php echo $result_new['image']; ?>" alt="First place"></a>
            <div class="card-body p-1">
                <h6><a class="text-decoration-none text-warning" href="#">
                        <p class="desc"><?php echo $result_new['productName']; ?></p>
                    </a>
                </h6>
                <p class="current_price text-center py-0 m-0">
                    <?php echo $fm->format_currency($result_new['price']). " "."VND"; ?></p>
            </div>
        </div>
    </div>
    <?php
				}
			}    
		?>
</div>

<?php
	include('inc/footer.php');
?>