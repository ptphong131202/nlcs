<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/customer.php';?>
<?php include_once '../helpers/format.php';?>
<?php 
	$cs = new customer();
?>
<div class="col-lg-10">
    <div class="container border rounded" style="padding-bottom:12%">
        <h4 class="m-4 text-primary">Danh sách khách hàng</h4>
        <div class="row inner-wrapper ms-4 me-4">
            <?php
				if(isset($del_slider)){
					echo $del_slider;
				}
			?>
            <table id="example" class="table table-bordered align-middle text-center table-striped table-responsive">
                <thead>
                    <tr>
                        <th style="" class="text-center">ID</th>
                        <th style="width:20%;" class="text-center">Tên</th>
                        <th style="width: 30%;" class="text-center">Địa chỉ</th>
                        <th style="" class="text-center">SĐT</th>
                        <th style="" class="text-center">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$customerlist = $cs->show_all_customers();
					if($customerlist) {
						$i = 0;
						while($result = $customerlist->fetch_assoc()) {
							$i++;
				?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['name']?></td>
                        <td>
                            <p class="desc"><?php echo $result['address'] ?></p>
                        </td>
                        <td><?php echo $result['phone'] ?></td>
                        <td><?php echo $result['email'] ?></td>
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