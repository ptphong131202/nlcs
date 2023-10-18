<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>

<?php 
	$cat = new category();
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$catName = $_POST['catName']; 
		$insert_cat = $cat->insert_category($catName);
	}
?>

	<div class="col-lg-10" >
        <div class="container border rounded">
            <h4 class="m-4 text-primary">Thêm danh mục</h4>
            <div class="mt-5"> 
                <?php
                    if(isset($insert_cat )){
                        echo $insert_cat;
                    }
                ?>
                <form action="catadd.php" method="post">	
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Tên danh mục</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="text" name="catName" placeholder="Nhập danh mục sản phẩm..." />
                        </div>
                    </div>

                    <div class="row" style="padding-bottom:21%">
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

 </div>


<?php include 'inc/footer.php';?>