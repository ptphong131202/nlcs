<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>

<?php 
    if(isset($_GET['catid']) && $_GET['catid']!=NULL){
        $id = $_GET['catid'];
    }
    else {
        echo "<script>window.location ='catlist.php'</script>";
    }

    $cat = new category();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$catName = $_POST['catName']; 
		$update_cat = $cat->update_category($catName,$id);
	}
?>

<div class="col-lg-10" >
        <div class="container border rounded">
            <h4 class="m-4 text-primary">Chỉnh sửa danh mục</h4>
            <div class="mt-5"> 
                <?php
                    if(isset($update_cat)) {
                        echo $update_cat;
                    }
                ?>
                <?php
                    $get_cate_name = $cat->getcatbyId($id);
                    if($get_cate_name) {
                        while($result = $get_cate_name->fetch_assoc()){
                ?>
                <form method="post">	
                    <div class="row mb-4">
                        <div class="col-2">
                            <label class="form-check-label col-form-label ms-4 fw-semibold" >Tên danh mục</label>
                        </div>
                        <div class="col-10 w-50">
                            <input class="form-control" type="text" value="<?php echo $result['catName'] ?>" name="catName" placeholder="Sửa danh mục sản phẩm..." />
                        </div>
                    </div>

                    <div class="row" style="padding-bottom:21%">
                        <div class="col-2"></div>
                        <div class="col-10 ">
                            <input class="btn btn-primary" type="submit" name="submit" Value="Update" />
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