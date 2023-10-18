<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/product.php';?>

<?php 
    if(isset($_GET['productid']) && $_GET['productid']!=NULL){
        $id = $_GET['productid'];
    }
    else {
        echo "<script>window.location ='productlist.php'</script>";
    }
    $pd = new product();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
		$update_product = $pd->update_product($_POST,$_FILES, $id);
	}          
?>
<div class="col-lg-10" >
        <div class="container border rounded">
            <h4 class="m-4 text-primary">Chỉnh sửa bánh</h4>
            <div class="mt-5"> 
                <?php
                    if(isset($update_product)) {
                        echo $update_product;
                    }
                ?>
                <?php
                    $get_product_by_id = $pd->getproductbyId($id);
                        if($get_product_by_id) {
                            while($result_product = $get_product_by_id->fetch_assoc()){
                ?>  
                <form action="" method="post" enctype="multipart/form-data">	
					<!-- Tên bánh -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Tên</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="text" name="productName" value=<?php echo $result_product['productName']?>  />
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
                            <option
                            <?php
                                if($result['catId'] == $result_product['catId']) {echo 'selected';}
                            ?>
                            value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?>
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
							<textarea class="form-control"  name="product_desc" style="height: 100px; resize:none"><?php echo $result_product['product_desc']?></textarea>
                        </div>
                    </div>


					<!-- Giá -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Giá</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="number" name="price"  value=<?php echo $result_product['price']?>/>
                        </div>
                    </div>
					<!-- Ảnh bánh -->
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Upload ảnh</label>
                        </div>
                        <div class="col-10 w-50">
                            <img src="uploads/<?php echo $result_product['image'] ?>" width="90">
                            <br>
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
                            <?php
                                if($result_product['type'] == 1) {
                            ?>
                                <option selected value="1">Giảm Giá</option>
                                <option value="0">Mới</option>
                            <?php
                                }else if($result_product['type'] == 0){
                            ?>     
                                <option value="1">Giảm Giá</option>
                                <option selected value="0">Mới</option>
                            <?php
                                }
                            ?>    
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
                            <?php
                                if($result_product['status_product'] == 1) {
                            ?>
                                <option selected value="1">Còn Hàng</option>
                                <option value="0">Hết Hàng</option>
                            <?php
                                }else if($result_product['status_product'] == 0){
                            ?>     
                                <option value="1">Còn Hàng</option>
                                <option selected value="0">Hết Hàng</option>
                            <?php
                                }
                            ?>    
                        </select>
                        </div>
                    </div>

                    <div class="row" style="padding-bottom:5%">
                        <div class="col-2"></div>
                        <div class="col-10 ">
                            <input class="btn btn-success" type="submit" name="submit" Value="Update" />
                        </div>
                    </div>
                </form>
                <?php
                    }
                }
                ?>
            </div>
        </div>  
    </div>    

 </div>
<?php include 'inc/footer.php';?>


