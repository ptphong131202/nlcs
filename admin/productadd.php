<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/product.php';?>


<?php 
	$pd = new product();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
		$insert_product = $pd->insert_product($_POST,$_FILES);
	}
?>

<div class="col-lg-10">
        <div class="container border rounded">
            <h4 class="m-4 text-primary">Thêm bánh</h4>
            <div class="mt-5"> 
                <form action="" method="post" enctype="multipart/form-data">	
					<!-- Tên bánh -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Tên</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="text" name="productName" placeholder="Nhập tên bánh..."  />
                        </div>
                    </div>
					<!-- Danh mục bánh -->
					<div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Danh mục bánh</label>
                        </div>
                        <div class="col-10 w-50">
                        <select class="form-select" aria-label="Default select example" name="category">
                            <option selected>Chọn danh mục bánh</option>
                            <?php
                                $cat = new category();
                                $catlist = $cat->show_category();
                                if($catlist) {
                                    while($result = $catlist->fetch_assoc()){
                            ?>
                            <option value="<?php echo $result['catId'] ?>">
                                <?php echo $result['catName'] ?>
                            </option>
                            <?php
                                    }
                                }    
                            ?>
                        </select>
                        </div>
                    </div>
					<!-- Mô tả bánh -->
					<div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Mô tả</label>
                        </div>
                        <div class="col-10 w-50">
							<textarea class="form-control"  name="product_desc" style="height: 100px; resize:none"></textarea>
                        </div>
                    </div>

					<!-- Số lượng -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Số lượng</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="number" name="sl_nhap" min="1" placeholder="Nhập số lượng..."  />
                        </div>
                    </div>

					<!-- Giá -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Giá</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="number" name="price"  placeholder="Nhập giá..."  />
                        </div>
                    </div>
					<!-- Ảnh bánh -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Upload ảnh</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="file" name="image"/>
                        </div>
                    </div>
                    
					<!-- Loại sản phẩm -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Loại</label>
                        </div>
                        <div class="col-10 w-50">
                        <select class="form-select" aria-label="Default select example" name="type">
                            <option selected>Chọn loại</option>
                            <option value="1">Giảm giá</option>
                            <option value="0">Mới</option>
                        </select>
                        </div>
                    </div>

					<!-- Trạng thái sản phẩm -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Trạng thái</label>
                        </div>
                        <div class="col-10 w-50">
                        <select class="form-select" aria-label="Default select example" name="status_product">
                            <option selected>Chọn trạng thái</option>
                            <option value="1">Còn Hàng</option>
                            <option value="0">Hết Hàng</option>
                        </select>
                        </div>
                    </div>

                    <div class="row" style="padding-bottom:5%">
                        <div class="col-2"></div>
                        <div class="col-10 ">
                            <input class="btn btn-success" type="submit" name="submit" Value="Thêm" />
                        </div>
                    </div>
                </form>
            </div>
        </div>  
    </div>    

 </div>

<?php include 'inc/footer.php';?>


