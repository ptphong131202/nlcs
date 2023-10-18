<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/product.php';?>
<?php include_once '../helpers/format.php';?>
<?php 
	$pd = new product();
	if(isset($_GET['productid'])){
        $id = $_GET['productid'];
		$delpro = $pd->del_product($id);
    }
?>
<div class="col-lg-10">
    <div class="container border rounded">
        <h4 class="m-4 inner-wrapper text-primary">Danh sách bánh</h4>

        <div class="row ms-4 me-4">
            <?php
			if(isset($delpro)){
				echo $delpro;
			}
		?>
            <table id="example" class="table table-bordered align-middle text-center table-striped table-responsive">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th style="width: 15%;">Tên</th>
                        <th>Hình Ảnh</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Danh Mục</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
					$pdlist = $pd->show_product();
					if($pdlist) {
						$i = 0;
						while($result = $pdlist->fetch_assoc()) {
							$i++;
				?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td>
                            <p class="desc"><?php echo $result['productName']?></p>
                        </td>
                        <td><img src="uploads/<?php echo $result['image'] ?>" width="80"></td>
                        <td><?php echo $result['sl_nhap']?></td>
                        <td><?php echo $result['price'] ?></td>
                        <td><?php echo $result['catName'] ?></td>
                        <td>
                            <?php
							if($result['status_product'] == 1) {
								echo 'Còn Hàng';
							}
							else if($result['status_product'] == 0) {
								echo 'Hết Hàng';
							}
						?>
                        </td>
                        <td>
                            <a class="btn btn-warning"
                                href="productedit.php?productid=<?php echo $result['productId'] ?>">Chỉnh sửa</a>
                            <a class="btn btn-danger" href="?productid=<?php echo $result['productId'] ?>"
                                onclick="return confirm('Are you sure!');">Xóa</a>
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