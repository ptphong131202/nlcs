<head>
    <title>Chỉnh sửa người dùng</title>
</head>
<?php
	include('inc/header.php');
?>
<?php
	$login_check = Session::get('customer_login');
	if($login_check==FALSE) {
		echo "<script>window.location ='login.php'</script>"; 
	}
?>
<?php
    $id = Session::get('customer_id');
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
        $UpdateCustomers = $cs->update_customers($_POST,$id);
	} 
?>
<form action="#">
    <div class="row" style="margin-top:15px">
        <div class="col-3"></div>
        <div class="col-6 border border-secondary rounded">
            <table class="table">
                <?php
                        $id = Session::get('customer_id');
                        $get_customers = $cs->show_customers($id);
                        if($get_customers){
                            while($result = $get_customers->fetch_assoc()){
                    ?>
                <tr>
                    <td>Tên</td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="name" value="<?php echo $result['name'];  ?>">
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><input class="form-control" type="email" name="email" value="<?php echo $result['email'];  ?>">
                    </td>
                </tr>
                <tr>
                    <td>SĐT</td>
                    <td>:</td>
                    <td><input class="form-control" type="number" name="phone" value="<?php echo $result['phone'];  ?>">
                    </td>
                </tr>
                <tr>
                    <td>Địa Chỉ</td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="address"
                            value="<?php echo $result['address'];  ?>"></td>
                </tr>
                <?php
                            }
                        }
                    ?>
            </table>

        </div>
        <div style="margin-left:24%" class="mt-4">
            <input class="btn btn-primary" type="submit" name="save" value="Submit"></input>
        </div>
    </div>
</form>
<?php
	include('inc/footer.php');
?>