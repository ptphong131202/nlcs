<head>
    <title>Người dùng</title>
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
<div class="row">
    <div class="col-3"></div>
    <div class="col-6 border border-secondary rounded">
        <table class="table table-borderless mt-2">
            <?php
                $id = Session::get('customer_id');
                $get_customers = $cs->show_customers($id);
                if($get_customers){
                    while($result = $get_customers->fetch_assoc()){
            ?>
            <tr>
                <td>Tên</td>
                <td>:</td>
                <td><?php echo $result['name'];  ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td><?php echo $result['email'];  ?></td>
            </tr>
            <tr>
                <td>SĐT</td>
                <td>:</td>
                <td><?php echo $result['phone'];  ?></td>
            </tr>
            <tr>
                <td>Địa Chỉ</td>
                <td>:</td>
                <td><?php echo $result['address'];  ?></td>
            </tr>
            <?php
                    }
                }
            ?>
        </table>
    </div>

    <div style="margin-left:35%" class="mt-4">
        <a class="btn btn-primary" class href="editprofile.php">Cập Nhật Thông Tin</a>
        <a class="btn btn-primary" href="changepassword.php">Đổi Mật Khẩu</a>
    </div>
</div>
<?php
	include('inc/footer.php');
?>