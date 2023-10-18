<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath.'/../helpers/format.php');
	include_once($filepath.'/../classes/cart.php');   
?>
<?php
	$ct = new cart();
	$fm = new format();

    if(isset($_GET['shiftid'])){ 
        $id = $_GET['shiftid'];
		$time = $_GET['time'];
		$total = $_GET['total'];
		$shifted = $ct->shifted($id,$time,$total);
    }

	if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit'])) {
		$filter_product = $ct->filter_product();
		
	}
	
?>
<div class="col-lg-10">
	<div class="container border rounded" >
	<h4 class="m-4 text-primary">Danh sách đơn hàng</h4>
	<div class="row inner-wrapper ms-4 me-4">
		<?php
			if(isset($shifted)) {
				echo $shifted;
			}
		?>
		<?php
			if(isset($del_shifted)) {
				echo $del_shifted;
			}
		?>
		<table id="example" class="table table-bordered align-middle table-striped table-responsive">
			<thead>
				<tr>
					<th class="text-center">STT</th>
					<th class="text-center">TG Đặt Hàng</th>
					<th class="text-center">Bánh</th>
					<th class="text-center">Số Lượng</th>
					<th class="text-center">Thành Tiền</th>
					<th class="text-center">Xem Thông Tin</th>
					<th class="text-center">Thao Tác</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					$get_inbox_cart = $ct->get_inbox_cart();
						if($get_inbox_cart) {
							$i = 0;
							$doanhthu = 0;
							while($result = $get_inbox_cart->fetch_assoc()){
								$i++;
				?>
				<tr>
				<td><?php echo $i ?></td>
					<td><?php echo $fm->formatDate($result['date_order']) ?></td>
					<td><?php echo $result['productName'] ?></td>
					<td><?php echo $result['quantity'] ?></td>
					<td><?php 
						$gia = $result['total'];
						echo $fm->format_currency($result['total']). " "."VND";  ?></td>
					<td><a class="text-decoration-none fw-semibold link-warning" href="customer.php?customerid=<?php echo $result['customer_id'] ?>">View Customer</a></td>
					<td>
						<?php
							if($result['status'] == '0') {										
						?>	
						<a href="?shiftid=<?php echo $result['id'];?>&total=<?php echo $result['total'] ?>&time=<?php echo $result['date_order'] ?>">Pending</a> 
						<?php
							}else if($result['status'] == '1'){								
						?>
							<?php
							echo 'Shipping...';
							?>
						<?php
							}else if($result['status'] == '2'){
						?>
						<?php
							$doanhthu += (int) $gia; 					
							echo 'N/A';
							}	
						?>
					</td>	
				</tr>
				<?php
					}
				}	
				?>	
			</tbody>  
							
		</table>   
	</div>
	<div class="row ms-3 ">
		<h5 class="mt-2 text-primary ">Doanh thu: <?php if(isset($doanhthu)) echo $fm->format_currency($doanhthu). " "."VND"; ?></h5>
		<form action="locsanphambanchay.php" method="GET" >
			<div class="row">
				<div class="col-2">
					<h5 class="mt-2 text-primary ">Lọc sản phẩm :</h5>
				</div>
				<div class="col-5">
					<select class="form-select w-50" aria-label="Default select example" name="sanpham">
						<option selected value="banchay">Bán chạy</option>
						<option value="bankhongchay">Bán không chạy</option>
						<option value="tungsanpham">Từng loại sản phẩm bán ra</option>
					</select>
					
				</div>
				
			</div>
			<div class="row">
				<div class="col-2"></div>
				<div class="col-5 my-3">
					<input class="btn btn-success"type="submit" value="Choose" name="submit" />
				</div>
			</div>
		</form>
	</div>
	</div>
</div>

<?php include 'inc/footer.php';?>
