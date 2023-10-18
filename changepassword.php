<head>
    <title>Đổi mật khẩu</title>
</head>
<?php
	include('inc/header.php');
?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
		$updatePassword = $cs->updatePassword($_POST);
	} 
?>
<div class="row">
    <div class="col-3"></div>
    <div class="col-lg-6 col-md-6">
        <div>
            <h2 class="text-center">Đổi Mật Khẩu</h2>
            <?php
                    if(isset($updatePassword)){
                        echo $updatePassword;
                    }
                ?>
            <form action="" method="POST">
                <div>
                    <label for="email" class="form-label"><b>Email:</b></label>
                    <input type="email" class="form-control" placeholder="Nhập vào email" name="email">
                </div>

                <div class="my-3">
                    <label for="password" class="form-label"><b>Mật Khẩu Cũ:</b></label>
                    <input type="password" class="form-control" placeholder="Nhập mật khẩu cũ" name="oldpassword">
                </div>

                <div class="my-3">
                    <label for="password" class="form-label"><b>Mật Khẩu Mới:</b></label>
                    <input type="password" class="form-control" name="newpassword" placeholder="Nhập mật khẩu mới">
                </div>

                <div class="row">
                    <div class="d-flex justify-content-end">
                        <input type="submit" name="submit" class="btn btn-primary mb-3" value="Xác Nhận">
                    </div>
                </div>

            </form>
        </div>
    </div>
    <hr />
    <?php
	include('inc/footer.php');
?>