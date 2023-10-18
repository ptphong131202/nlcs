<head>
    <title>Đăng nhâp</title>
</head>
<?php
	include('inc/header.php');
?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
		$insertCustomers = $cs->insert_customers($_POST);
	} 
?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
		$loginCustomers = $cs->login_customers($_POST);
	} 
?>
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div>
            <h2 class="text-center">Đăng nhập</h2>


            <?php
                    if(isset($loginCustomers)){
                        echo $loginCustomers;
                    }
			    ?>
            <form action="" method="POST">
                <div>
                    <label for="email" class="form-label"><b>Email:</b></label>
                    <input type="email" class="form-control" placeholder="Nhập vào email" name="email">
                </div>

                <div class="my-3">
                    <label for="password" class="form-label"><b>Mật khẩu:</b></label>
                    <input type="password" class="form-control" placeholder="Nhập vào mật khẩu" name="password">
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="mt-2">
                            <a class="mt-2 text-decoration-none" href="changepassword.php">Quên mật khẩu?</a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mt-2">
                            <label for="remember" class="form-check-label">
                                <input id="remember" type="checkbox" class="form-check-input">
                                Ghi nhớ tôi
                            </label>
                        </div>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <input type="submit" name="login" class="btn btn-primary mb-3" value="Đăng nhập">
                    </div>
                </div>

            </form>
        </div>


    </div>
    <div class="col-lg-6 col-md-6">
        <div>
            <h2 class="text-center">Đăng Ký</h2>

            <?php
                    if(isset($insertCustomers)){
                        echo $insertCustomers;
                    }
                ?>
            <form action="" method="POST">
                <div>
                    <label for="email" class="form-label"><b>Tên:</b></label>
                    <input type="text" class="form-control" placeholder="Nhập tên" name="name">
                </div>

                <div class="my-3">
                    <label for="address" class="form-label"><b>Địa Chỉ:</b></label>
                    <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="address">
                </div>

                <div class="my-3">
                    <label for="phone" class="form-label"><b>SĐT:</b></label>
                    <input type="number" class="form-control" placeholder="Nhập SĐT" name="phone">
                </div>

                <div>
                    <label for="email" class="form-label"><b>Email:</b></label>
                    <input type="email" class="form-control" placeholder="Nhập Email" name="email">
                </div>

                <div class="my-3">
                    <label for="password" class="form-label"><b>Mật Khẩu:</b></label>
                    <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password">
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit" name="submit">Đăng Ký</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
	include('inc/footer.php');
?>