<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    $filepath = realpath(dirname(__FILE__));
    // include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
	include_once($filepath.'/../classes/cart.php');   
?>
<?php
	$ct = new cart();
	$fm = new format();
    if(isset($_GET['shiftid'])){ 
        $id = $_GET['shiftid'];
		$time = $_GET['time'];
		$price = $_GET['price'];
		$shifted = $ct->shifted($id,$time,$price);
    }
	if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit'])) {
		$filter_product = $ct->filter_product();
		
	}	
?>
<div class="col-lg-10" >
	<div class="container border rounded" style="padding-bottom:16%">
	<h4 class="m-4 text-primary">Lọc sản phẩm</h4>
	<div class="row inner-wrapper ms-4 me-4 ">
		<table id="example" class="table table-bordered align-middle text-center table-striped table-responsive">
			<thead>
				<tr>
					<th class="text-center">STT</th>
					<th class="text-center">ID_Banh</th>
					<th class="text-center">Tên bánh</th>
					<th class="text-center">Số lượng</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					if($filter_product) {
						$i = 0;
						while($result = $filter_product->fetch_assoc()){
							$i++;
				?>
				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo $result['productId'] ?></td>
					<td><?php echo $result['productName'] ?></td>
					<td><?php echo $result['soluong'] ?></td>
				</tr>
				<?php
						}
					}	
				?>	
			</tbody>  
							
		</table>   
	</div>
	</div>
</div>

<?php include 'inc/footer.php';?>
