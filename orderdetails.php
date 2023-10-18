<head>
    <title>Đơn hàng</title>
</head>
<?php
	include('inc/header.php');
?>
<?php
	$login_check = Session::get('customer_login');
	if($login_check==FALSE) {
		echo "<script>window.location ='index.php'</script>"; 
	}
	if(isset($_GET['confirmid'])){
        $quantity = $_GET['quantity'];  
		$productId = $_GET['productId'];
        $update_quantity = $product->update_quantity($productId,$quantity);
        
        $id = $_GET['confirmid'];  
		$time = $_GET['time'];
		$total = $_GET['total'];
		$shifted_confirm = $ct->shifted_confirm($id,$time,$total);
        
    }
    if(isset($_GET['delid'])){
        $id = $_GET['delid'];
		$time = $_GET['time'];
		$total = $_GET['total'];
		$del_shifted = $ct->del_shifted_customer($id,$time,$total);
    }
?>
<div class="row text-center">
    <div class="col-12">
        <table>
            <thead>
                <tr>
                    <th style="width:5%">STT</th>
                    <th style="width:12%">Sản Phẩm</th>
                    <th style="width:12%">Hình Ảnh</th>
                    <th style="width:10%">Số Lượng</th>
                    <th style="width:10%">Thành Tiền</th>
                    <th style="width:15%">Ngày Đặt</th>
                    <th style="width:10%">Trạng Thái</th>
                    <th style="width:10%">Hành Động</th>
                </tr>
            </thead>
            <?php
								$customer_id = Session::get('customer_id');
								$get_cart_ordered = $ct->get_cart_ordered($customer_id);
								if($get_cart_ordered) {
									$i = 0;
									$qty = 0;
									while($result = $get_cart_ordered->fetch_assoc()) {	
										$i++;								
							?>
            <tbody>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><a href="#"></a><?php echo $result['productName'] ?></td>
                    <td><a href="#"><img img style="width:50%" src="admin/uploads/<?php echo $result['image'] ?>"
                                alt="" /></a></td>
                    <td><a class="text-decoration-none text-warning" href="#"><?php echo $result['quantity'] ?></a></td>
                    <td><?php echo $fm->format_currency($result['total']). " "."VND"; ?></td>
                    <td>
                        <?php 
											echo $fm->formatDate($result['date_order']);
										?>
                    </td>
                    <td>
                        <?php
										if($result['status'] == '0') {
											echo 'Đang xử lý';
										}
										else if($result['status'] == '1'){
										?>
                        <span>Đang giao...</span>
                        <?php
										}else {
											echo 'Đã Nhận';
										}
										?>
                    </td>
                    <?php
										if($result['status'] == '0') {
									?>
                    <td><a class="btn btn-danger"
                            href="?delid=<?php echo $result['id'];?>&total=<?php echo $result['total'] ?>&time=<?php echo $result['date_order'] ?>">Xóa</a>
                    </td>
                    <?php
										}else if($result['status'] =='1'){
									?>
                    <td><a class="btn btn-success"
                            href="?confirmid=<?php echo $customer_id;?>&productId=<?php echo $result['productId']?>&quantity=<?php echo $result['quantity']?>&total=<?php echo $result['total']?>&time=<?php echo $result['date_order'] ?>">Xác
                            nhận</a></td>
                    <?php
									}else if($result['status'] =='2'){   
									?>
                    <td><?php echo 'N/A' ?></td>
                    <?php
									}
									?>
                </tr>
            </tbody>
            <?php
								}
							}
							?>
        </table>
    </div>
</div>
<?php
	include('inc/footer.php');
?>