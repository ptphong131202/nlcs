<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/product.php';?>
<?php
	// On/Off Slider
	$product = new product();
	if(isset($_GET['type_slider']) && isset($_GET['type'])  ) {
		$id = $_GET['type_slider'];
		$type = $_GET['type'];
		$update_type_slider = $product->update_type_slider($id,$type);
	}
	//Xóa slider
	if(isset($_GET['slider_del'])) {
		$id = $_GET['slider_del'];
		$del_slider = $product->del_slider($id);
	}
?>
	<div class="col-lg-10">
		<div class="container border rounded">
		<h4 class="m-4 text-primary">Danh sách slider</h4>
		
		<div class="row inner-wrapper ms-4 me-4 "> 
			<?php
				if(isset($del_slider)){
					echo $del_slider;
				}
			?>
			<table id="example" class="table table-bordered align-middle text-center table-striped table-responsive" >
				<thead>
					<tr>
						<th class="text-center">STT</th>
						<th class="text-center">Tiêu đề</th>
						<th class="text-center">Hình Ảnh</th>
						<th class="text-center">Loại</th>
						<th class="text-center">Thao Tác</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						$product = new product();
						$get_slider = $product->show_slider_list();
						if($get_slider) {
							$i = 0;
							while($result_slider = $get_slider->fetch_assoc()) {
								$i++;
					?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $result_slider['sliderName'] ?></td>
						<td><img height="120px" width="400px" src="uploads/<?php echo $result_slider['slider_image'] ?>" alt=""/></td>
						<td>
							<?php
								if($result_slider['type'] == 1) {
							?>	
							<a class="text-decoration-none fw-semibold link-danger"  href="?type_slider=<?php echo $result_slider['sliderId']?>&type=0">Off</a> 
							<?php
							}else{
							?>
							<a class="text-decoration-none fw-semibold link-success" href="?type_slider=<?php echo $result_slider['sliderId']?>&type=1">On</a> 
							<?php
							}
							?>
						</td>
						<td>
							<a class="btn btn-danger" href="?slider_del=<?php echo $result_slider['sliderId']?>" onclick="return confirm('Are you sure!');" >Xóa</a> 
						</td>	
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
</div>
</div>

<?php include 'inc/footer.php';?>
