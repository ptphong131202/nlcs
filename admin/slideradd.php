<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/product.php';?>
<?php
    $product = new product();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
		$insert_slider = $product->insert_slider($_POST, $_FILES);
	}
?>
    <div class="col-lg-10" >
        <div class="container border rounded">
            <h4 class="m-3 text-primary">Thêm slider</h4>
            <div class="mt-5"> 
            <?php
                if(isset($insert_slider )){
                    echo $insert_slider;
                }
            ?>
                <form action="slideradd.php" method="post" enctype="multipart/form-data">	
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold">Tiêu đề</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="text" name="sliderName" placeholder="Nhập tiêu đề slider..."  />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Upload ảnh</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="file" name="image"/>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Type</label>
                        </div>
                        <div class="col-10 w-50">
                        <select class="form-select" aria-label="Default select example" name="type">
                            <option selected>Chọn type</option>
                            <option value="1">On</option>
                            <option value="0">Off</option>
                        </select>
                        </div>
                    </div>

                    <div class="row" style="padding-bottom:11%">
                        <div class="col-2"></div>
                        <div class="col-10 ">
                            <input class="btn btn-success" type="submit" name="submit" Value="Thêm" />
                        </div>
                    </div>
                </form >
            </div>
        </div>
        </div>    
    </div>
 </div>

<?php include 'inc/footer.php';?>


