<head>
    <title>Giỏ hàng</title>
</head>
<?php
	include('inc/header.php');
?>
<?php
	$login_check = Session::get('customer_login');
	if($login_check==FALSE) {
		echo "<script>window.location ='index.php'</script>"; 
	}
?>
<?php
	if(isset($_GET['cartid'])){
        $cartid = $_GET['cartid'];
		$delcart = $ct->del_product_cart($cartid);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $cartId = $_POST['cartId'];
        $quantity = $_POST['quantity'];
        $update_quantity_cart = $ct->update_quantity_cart($quantity,$cartId);
    }
    if(isset($_GET['orderid']) && $_GET['orderid']=='order'){
        $customer_id = Session::get('customer_id');
        $insertOrder = $ct->insertOrder($customer_id);
        $delCart = $ct->del_all_data_cart();
        echo "<script>window.location ='orderdetails.php'</script>"; 
    }
?>

<!-- Giỏ Hàng -->

<form action="" method="POST">
    <div class="row text-center">
        <div class="col-12">
            <?php
                    if(isset($update_quantity_cart)){
                        echo $update_quantity_cart;
                    }
                ?>
            <?php
                    if(isset($delcart)){
                        echo $delcart;
                    }
                ?>
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">STT</th>
                        <th style="width:20%">Sản Phẩm</th>
                        <th style="width:20%">Hình Ảnh</th>
                        <th style="width:12%">Giá</th>
                        <th style="width:15%">Số Lượng</th>
                        <th style="width:15%">Tổng Cộng</th>
                        <th style="width:5%">Xóa</th>
                    </tr>
                </thead>
                <?php
                        $get_product_cart = $ct->get_product_cart();
                        if($get_product_cart) {
                            $i=0;
                            $subtotal = 0;
                            $qty = 0;
                            while($result = $get_product_cart->fetch_assoc()) {		
                                $i++;								
                    ?>
                <tbody>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><a href="#"></a><?php echo $result['productName'] ?></td>
                        <td><a href="#"><img img style="width:50%" src="admin/uploads/<?php echo $result['image'] ?>"
                                    alt="" /></a></td>
                        <td><?php echo $fm->format_currency($result['price']). " "."VND"; ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="cartId" value="<?php echo $result['cartId'] ?>" />
                                <div class="row">
                                    <div class="col-6">
                                        <input class="form-control" min="1" max="<?php echo $result['sl_conlai'] ?>"
                                            name="quantity" value="<?php echo $result['quantity'] ?>" type="number"
                                            class="w-50">
                                    </div>
                                    <div class="col-6 p-0">
                                        <input class="btn btn-warning" type="submit" name="submit" value="Update" />
                                    </div>

                                </div>

                            </form>
                        </td>
                        <td>
                            <?php 
                                    $total = $result['price'] * $result['quantity'];
                                    echo $fm->format_currency($total)." "."VND";
                                ?>
                        </td>
                        <td><a class="btn btn-danger" onclick="return confirm('Are you sure?')"
                                href="?cartid=<?php echo $result['cartId'] ?>">Xóa</a></td>
                    </tr>
                </tbody>
                <?php
                        $subtotal += $total; 	
                        $qty += $result['quantity'];	
                            }
                        }
                    ?>
            </table>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-lg-8 col-md-8">
            <?php
                    $check_cart = $ct->check_cart();
                        if($check_cart == FALSE) {	
                            echo 'Giỏ hàng đang rỗng!!!';
                            
                        }
                ?>
        </div>
        <?php
                $check_cart = $ct->check_cart();
                    if($check_cart) {				
            ?>
        <div class="col-lg-4 col-md-4">
            <div>
                <h3 class="text-center fw-bolder">Chi Tiết</h3>
                <div class="border rounded ">
                    <div class="row m-3">
                        <div class="col-4">Tổng cộng:</div>
                        <div class="col-8 text-end">
                            <?php 							
                                    echo $fm->format_currency($subtotal)." "."VND";
                                    Session::set('sum',$subtotal);
                                    Session::set('qty',$qty);
                                ?>
                        </div>
                    </div>

                    <div class="row m-3">
                        <div class="col-4"></div>
                        <div class="col-8 text-end">
                            Free Ship
                        </div>
                    </div>

                    <div class="row m-3">
                        <div class="col-4">Thành Tiền</div>
                        <div class="col-8 text-end">
                            <?php 										
                                    $gtotal = $subtotal;
                                    echo $fm->format_currency($gtotal)." "."VND";
                                ?>
                        </div>
                    </div>

                </div>
                <div class="mt-3">
                    <a class="btn btn-success" href="?orderid=order" onclick="myFunction()">Đặt Hàng</a>
                </div>
            </div>
        </div>
        <?php
                }
            ?>
    </div>
</form>

<script>
function myFunction() {
    alert("Bạn đã đặt hàng thành công, vui lòng nhấn OK để xem chi tiết lịch sử đặt hàng");
}
</script>
<?php
	include('inc/footer.php');
?>