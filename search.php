<head>
    <title>Tìm kiếm</title>
</head>
<?php
	include('inc/header.php');
?>
<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tukhoa'])) {
        $tukhoa = $_POST['tukhoa']; 
    }
	else{
		echo "<script>window.location ='index.php'</script>";
	}
	
?>
<div class="row">
    <div class="col-12 text-center">
        <div class="section_title">
            <h2>Tìm kiếm từ khóa: <?php echo $tukhoa; ?></h2>
            <p>Sản phẩm mang lại sự trải nghiệm tuyệt vời nhất</p>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="row">
        <?php
                $search_product = $product->search_product($tukhoa);
                if($search_product) {
                    while($result = $search_product->fetch_assoc()){
            ?>

        <div class="col-2 mb-4 ">
            <div class="card shadow-lg" style="height: 250px;">
                <a href="product-details.php?proid=<?php echo $result['productId']; ?>"><img
                        style="width: 254px;height: 130px; z-index:-1;" class="img-fluid"
                        src="admin/uploads/<?php echo $result['image']; ?>" alt="First place"></a>
                <div class="card-body">
                    <h6><a class="text-decoration-none text-warning" href="#">
                            <p class="desc"><?php echo $result['productName']; ?></p>
                        </a>
                    </h6>
                    <p class="current_price text-center py-0 m-0">
                        <?php echo $fm->format_currency($result['price']). " "."VND"; ?></p>
                    <?php
                            if($result['type'] == '1') {
                        ?>
                    <p class="text-decoration-line-through text-center py-0 m-0 price-last">
                        <?php echo $fm->format_currency($result['price']+$result['price']*0.07). " "."VND"; ?></p>
                    <?php
                            }
                        ?>
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