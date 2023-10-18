<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>

<?php 
	$cat = new category(); 
	if(isset($_GET['delid'])){
        $id = $_GET['delid'];
		$delcat = $cat->del_category($id);
    }

	// On/Off Category
	if(isset($_GET['mode_category']) && isset($_GET['mode'])  ) {
		$id = $_GET['mode_category'];
		$mode = $_GET['mode'];
		$update_mode_category = $cat->update_mode_category($id,$mode);
	}
?>

<div class="col-lg-10" >
	<div class="container border rounded">
		<h4 class="m-4 text-primary">Danh mục bánh</h4>
		<div class="row inner-wrapper ms-4 me-4">
			<?php
				if(isset($delcat)) {
					echo $delcat;
				}
			?>  
			<table id="example" class="table table-bordered align-middle text-center table-striped table-responsive">
				<thead>
					<tr>
						<th class="text-center">STT</th>
						<th class="text-center">Tên Danh Mục</th>
						<th class="text-center">Mode</th>
						<th class="text-center">Thao Tác</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						$show_cate = $cat->show_category();
						if($show_cate) {
							$i = 0;
							while($result = $show_cate->fetch_assoc()){
								$i++;	
					?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $result['catName'] ?></td>
						<td>
							<?php
								if($result['mode'] == 1) {
							?>	
							<a class="text-decoration-none fw-semibold link-danger" href="?mode_category=<?php echo $result['catId']?>&mode=0">Off</a> 
							<?php
							}else{
							?>
							<a class="text-decoration-none fw-semibold link-success" href="?mode_category=<?php echo $result['catId']?>&mode=1">On</a> 
							<?php
							}
							?>
						</td>	
						<td>
							<a class="btn btn-warning" href="catedit.php?catid=<?php echo $result['catId'] ?>">Chỉnh sửa</a>
							<a class="btn btn-danger" href="?delid=<?php echo $result['catId'] ?>" onclick="return confirm('Are you sure!');" >Xóa</a> 
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

<?php include 'inc/footer.php';?>

