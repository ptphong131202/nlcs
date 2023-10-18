<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/customer.php';?>
<?php
	$cs = new customer();
	//Xóa comment
	if(isset($_GET['comment_del'])) {
		$id = $_GET['comment_del'];
		$del_comment = $cs->del_comment($id);
	}
?>

<div class="col-lg-10">
    <div class="container border rounded" style="padding-bottom:9%">
        <h4 class="m-4 text-primary">Danh sách bình luận</h4>

        <div class="row inner-wrapper ms-4 me-4">
            <?php
			if(isset($del_comment)){
				echo $del_comment;
			}
		?>
            <table id="example" class="table table-bordered align-middle text-center table-striped table-responsive">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Sản Phẩm</th>
                        <th class="text-center">id_kh</th>
                        <th class="text-center">Tên KH</th>
                        <th class="text-center">Bình luận</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
					$get_comment = $cs->show_comment();
					if($get_comment) {
						$i = 0;
						while($result_comment = $get_comment->fetch_assoc()) {
							$i++;
				?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result_comment['productName'] ?></td>
                        <td><?php echo $result_comment['customer_id'] ?></td>
                        <td><?php echo $result_comment['name'] ?></td>
                        <td><?php echo $result_comment['binhluan'] ?></td>

                        <td>
                            <a class="btn btn-danger" href="?comment_del=<?php echo $result_comment['binhluan_id']?>"
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



<?php include 'inc/footer.php';?>