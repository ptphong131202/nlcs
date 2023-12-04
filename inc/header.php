<?php
include('lib/session.php');
Session::init(); //Khởi tạo session
?>

<?php
include_once('lib/database.php');
include_once('helpers/format.php');
spl_autoload_register(function($class){
    include_once "classes/".$class.".php";
});
$db = new Database();
$fm = new Format();
$ct = new cart();
$us = new user();
$cat = new category();
$cs = new customer();
$product = new product();
?>
<?php
if(isset($_GET['customer_id'])){
    $customer_id = $_GET['customer_id'];
    $delCart = $ct->del_all_data_cart();
    $delCompare = $ct->del_compare($customer_id );
    Session::destroy();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/base77.css">
</head>


<body>
<div class="container ">
<!-- Header -->
<div class="row bg-white position-fixed fixed-top px-5 py-2 header">
<div class="col-2">
<a href="/b2014598/index.php">
<h1 class="text-center"><img class="logo" src="img/logo/logo1.png" /></h1>
</a>
</div>
<div class="col-10">
<nav class="navbar navbar-expand-lg bg-light">
<div class="container-fluid fst-italic">
<a class="nav-link active" aria-current="page" href="index.php">Trang Chủ</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<li class="nav-item">
<a class="nav-link active" aria-current="page" href="shop_category.php">Cửa
Hàng</a>
</li>
<li class="nav-item">
<a class="nav-link active" aria-current="page" href="about.php">Giới Thiệu</a>
</li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" role="button"
data-bs-toggle="dropdown" aria-expanded="false">
Trang
</a>
<ul class="dropdown-menu">
<?php
$login_check = Session::get('customer_login');
if($login_check==false) {
    echo '<li><a class="dropdown-item" href="login.php">Tài Khoản</a></li>';                         
}
else{
    echo '<li><a class="dropdown-item" href="profile.php">Tài Khoản</a></li>';
}
?>

<?php
$login_check = Session::get('customer_login');
if($login_check==false) {
    echo '<li><a class="dropdown-item" href="login.php">So Sánh</a></li>';                         
}
else{
    echo '<li><a class="dropdown-item" href="compare.php">So Sánh</a></li>';
}
?>

<?php
$login_check = Session::get('customer_login');
if($login_check==false) {
    echo '<li><a class="dropdown-item" href="login.php">Yêu Thích</a></li>';                         
}
else{
    echo '<li><a class="dropdown-item" href="wishlist.php">Yêu Thích</a></li>';
}
?>

<?php
$login_check = Session::get('customer_login');
if($login_check==false) {
    echo '<li><a class="dropdown-item" href="login.php">Giỏ Hàng</a></li>';                         
}
else{
    echo '<li><a class="dropdown-item" href="cart.php">Giỏ Hàng</a></li>';
}
?>

<?php
$login_check = Session::get('customer_login');
if($login_check==false) {
    echo '<li><a class="dropdown-item" href="login.php">Đơn Hàng</a></li>';                         
}
else{
    echo '<li><a class="dropdown-item" href="orderdetails.php">Đơn Hàng</a></li>';
}
?>

</ul>
</li>
<li class="nav-item">
<a class="nav-link active" aria-current="page" href="contact.php">Liên Hệ</a>
</li>
<?php
$login_check = Session::get('customer_login');
if($login_check==false) {
    echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="login.php">Đăng Nhập</a></li>';
}
else{
    echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="?customer_id='.Session::get('customer_id') .'">Đăng Xuất</a></li>';
}     
?>

</ul>
<form class="d-flex" role="search" action="search.php" method="POST">
<input class="form-control me-2" type="search" placeholder="Search"
aria-label="Search" name="tukhoa">
<button class="btn btn-outline-success" name="search_product"
type="submit">Search</button>
</form>
</div>
</div>
</nav>
</div>
</div>
<hr />

<div class="container">
<div style="width:100%; height: 80px"></div>
</div>