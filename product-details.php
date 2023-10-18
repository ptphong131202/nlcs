<head>
    <title>Đơn hàng</title>
</head>
<?php
	include('inc/header.php');
?>
<?php
    $customer_id = Session::get('customer_id');
    if(isset($_GET['proid']) && $_GET['proid']!=NULL){
        $id = $_GET['proid'];
    }
    else {
        echo "<script>window.location ='404.php'</script>";
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $quantity = $_POST['quantity'];
        
		$Addtocart = $ct->add_to_cart($quantity,$id);
	} 
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])) {
        $productId = $id;
		$insertCompare = $product->insertCompare($productId,$customer_id);
        echo "<script>window.location ='compare.php'</script>";
	} 
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlist'])) {
        $productId = $id;
		$insertWishlist = $product->insertWishlist($productId,$customer_id);
        echo "<script>window.location ='wishlist.php'</script>";
	} 
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['binhluan_submit'])) {
		$insert_binhluan = $cs->insert_binhluan($customer_id,$id);
	} 
?>
<div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5">
                <div>
                    <div>
                        <a href="#">
                            <?php
                                    $get_product_details = $product->get_details($id);
                                    if($get_product_details){
                                        while($result_details = $get_product_details->fetch_assoc()){
                                ?>
                            <img class="shadow-lg" src="admin/uploads/<?php echo $result_details['image']; ?>"
                                alt="big-1" style="width: 100%">
                            <?php
                                        }
                                    }
                                ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7">
                <div>
                    <?php
                            $get_product_details = $product->get_details($id);
                            if($get_product_details){
                                while($result_details = $get_product_details->fetch_assoc()){
                        ?>
                    <form action="#" method="POST">
                        <div style="margin-left:13px">
                            <h3><?php echo $result_details['productName'] ?></h3>

                            <div>
                                <span><?php echo $fm->format_currency($result_details['price']). " "."VND"; ?></span>
                            </div>
                            <div class="fw-light">
                                <p><?php echo $result_details['product_desc'] ?> </p>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label class="col-form-label">Số Lượng: </label>

                                </div>
                                <div class="col">
                                    <input class="form-control" min="1" max="<?php echo $result_details['sl_conlai'] ?>"
                                        value="1" type="number" name="quantity">
                                </div>
                                <?php
                                        if(isset($Addtocart)) {
                                            echo $Addtocart;
                                        }
                                    ?>
                            </div>

                            <div class="my-3">
                                <span>Số lượng trong kho: <?php echo $result_details['sl_conlai']  ?></span>
                            </div>
                            <div>
                                <?php
                                        $login_check = Session::get('customer_login');
                                        if($login_check==false) {
                                            echo '<input class="btn btn-success" type="submit" value="Thêm vào giỏ"></input>';
                                        }
                                        else{
                                            echo '<input class="btn btn-success" type="submit" name="submit" value="Thêm vào giỏ"></input>';
                                        }
                                    ?>
                            </div>
                            <div>
                                <?php
                                        $login_check = Session::get('customer_login');
                                        if($login_check==false) {
                                            echo '';
                                        }
                                        else{
                                            echo '<input class="btn btn-success my-4    " type="submit" name="wishlist" value="Thêm vào yêu thích"></input> <br>';
                                        }
                                    ?>
                                <?php
                                        $login_check = Session::get('customer_login');
                                        if($login_check==false) {
                                            echo '';
                                        }
                                        else{
                                            echo '<input class="btn btn-success" type="submit" name="compare" value="Thêm vào so sánh"></input>';
                                        }
                                    ?>
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
</div>
<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <?php
                        $show_name = $cs->show_name($id);

                        if($show_name){
                            while($result = $show_name->fetch_assoc()){
                    ?>
                <div>
                    <strong><?php echo $result['name'].':' ?></strong>
                    <span><?php echo $result['binhluan']; ?></span>
                </div>
                <?php
                        }
                    }
                    ?>
                <div style="margin-top:20px;width:50%">
                    <div>
                        <form action="" method="POST">
                            <h2>Đánh giá</h2>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea style="resize: none; height: 200px" name="binhluan"
                                            class="form-control" placeholder="Leave a comment here"
                                            id="floatingTextarea2" style="height: 100px"></textarea>
                                        <label for="floatingTextarea2">Bình luận ngay</label>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    if($customer_id) {
                                ?>
                            <input onclick="myFunction1()" class="btn btn-success" type="submit" name="binhluan_submit"
                                value="Submit"></input>
                            <?php
                                    }else {
                                ?>
                            <input onclick="myFunction2()" class="btn btn-success" type="submit" value="Submit"></input>
                            <?php
                                }
                                ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section>
    <div class="row mt-3">
        <div class="col-12 text-center">
            <div>
                <h2>Sản Phẩm Liên Quan</h2>
                <p>Sản phẩm có thể bạn sẽ thích thú với nó!!!</p>
            </div>
        </div>
    </div>
    <div>
        <div class="row ">
            <?php
                        $getproduct_relation = $product->getproduct_relation($id);
                        if($getproduct_relation) {
                            while($result_relation = $getproduct_relation->fetch_assoc()){
                    ?>
            <div class="col-3 mb-5">
                <div class="card" style="width: 16rem;">
                    <a href="product-details.php?proid=<?php echo $result_relation['productId']; ?>"><img
                            style="width: 254px;height: 130px;" class="img-fluid"
                            src="admin/uploads/<?php echo $result_relation['image']; ?>" alt="First place"></a>
                    <div class="card-body">
                        <h3><a class="text-decoration-none text-warning"
                                href="#"><?php echo $result_relation['productName']; ?></a></h3>
                        <span
                            class="current_price"><?php echo $fm->format_currency($result_relation['price']). " "."VND"; ?></span>
                        <?php
                                    if($result_relation['type'] == '1') {
                                ?>
                        <span
                            class="text-decoration-line-through"><?php echo $fm->format_currency($result_relation['price']+$result_relation['price']*0.07). " "."VND"; ?></span>
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
    </div>
</section>
<script>
function myFunction1() {
    alert("Bình luận thành công nhưng sẽ được admin kiểm duyệt");
}

function myFunction2() {
    alert("Vui lòng đăng nhập để được bình luận");
}
</script>
<?php
	include('inc/footer.php');
?>