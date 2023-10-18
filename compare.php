<head>
    <title>So sánh sản phẩm</title>
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
    if(isset($_GET['proid'])){
        $customer_id = Session::get('customer_id');
        $proid = $_GET['proid'];
		$del_compare = $product->del_compare($proid,$customer_id);
    }
?>
<div class="row text-center">
    <div class="col-12">
        <?php
                    if(isset($del_compare)){
                        echo $del_compare;
                    }
                ?>
        <table>
            <thead>
                <tr>
                    <th style="width:5%">STT</th>
                    <th style="width:30%">Sản Phẩm</th>
                    <th style="width:15%">Hình Ảnh</th>
                    <th style="width:20%">Giá</th>
                    <th style="width:20%">Thao tác</th>
                </tr>
            </thead>
            <?php
                        $customer_id = Session::get('customer_id');
                        $get_compare = $product->get_compare($customer_id);
                        if($get_compare) {
                            $i = 0;
                            while($result = $get_compare->fetch_assoc()) {	
                                $i++;									
                    ?>
            <tbody>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $result['productName'] ?></td>
                    <td><a href="#"><img img style="width:50%" src="admin/uploads/<?php echo $result['image'] ?>"
                                alt="" /></a></td>
                    <td><?php echo $fm->format_currency($result['price']). " "."VND"; ?></td>
                    <td><a class="btn btn-info" href="product-details.php?proid=<?php echo $result['productId'] ?>">Xem
                            Chi Tiết</a></td>
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