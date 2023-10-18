<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
?>


<?php
    class product 
    {
        private $db;
        private $fm;

        public function __construct() 
        {
            $this->db = new Database();
            $this->fm = new Format();
        } 
        // Tìm kiếm sản phẩm
        public function search_product($tukhoa) {
                $tukhoa = $this->fm->validation($tukhoa); //Kiểm tra là biến từ khóa đã có chưa
                if($tukhoa != NULL) {
                    $query = "SELECT * FROM tbl_product WHERE productName like '%$tukhoa%'";
                    $result = $this->db->select($query);
                    return $result;
                }
        }
        // Thêm sản phẩm
        public function insert_product($data,$files)
        {
            $productName = mysqli_real_escape_string($this->db->link,$data['productName']);
            $category = mysqli_real_escape_string($this->db->link,$data['category']);
            $product_desc = mysqli_real_escape_string($this->db->link,$data['product_desc']);
            $sl_nhap = mysqli_real_escape_string($this->db->link,$data['sl_nhap']);
            $price = mysqli_real_escape_string($this->db->link,$data['price']);
            $type = mysqli_real_escape_string($this->db->link,$data['type']);
            $status_product = mysqli_real_escape_string($this->db->link,$data['status_product']);
            //Kiểm tra hình ảnh và lấy hình ảnh cho vào folder 
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).".".$file_ext;
            $upload_image = "uploads/".$unique_image;

            if($productName == "" || $category == "" || $product_desc == "" || $price == "" || $sl_nhap == "" || $type == "" || $status_product == "" || $file_name = "") {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else {
                move_uploaded_file($file_temp,$upload_image);
                $query = "INSERT INTO tbl_product(productName,catId,product_desc,sl_nhap,sl_conlai,price,type,status_product,image) 
                          VALUES('$productName','$category','$product_desc','$sl_nhap','$sl_nhap','$price','$type','$status_product','$unique_image')";
                $result = $this->db->insert($query);
                if($result) {
                    $alert = "<span class='success'>Insert Product successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Insert Product fail</span>";
                    return $alert;
                }
            }
        }
        // Thêm vào bảng so sánh sản phẩm
        public function insertCompare($productId,$customer_id) {
            $productId = mysqli_real_escape_string($this->db->link,$productId);
            $customer_id = mysqli_real_escape_string($this->db->link,$customer_id);

            $check_compare = "SELECT * FROM tbl_compare  WHERE productId = '$productId' AND customer_id = '$customer_id'";
            $result_check_compare = $this->db->select($check_compare);
            if($result_check_compare) {
                $msg = "<span class='error'>Product has Already been added to Compare</span>";
                return $msg;
            }else{
                $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
                $result = $this->db->select($query)->fetch_assoc();

                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];

                $query_insert = "INSERT INTO tbl_compare(productId,price,image,customer_id,productName) 
                VALUES('$productId','$price','$image','$customer_id','$productName')";
                $insert_compare = $this->db->insert($query_insert);
                if($insert_compare) {
                    $alert = "<span class='success'>Compare added successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Compare added fail</span>";
                    return $alert;
                }
            }
        }
        // Thêm vào wishlist
        public function insertWishlist($productId,$customer_id) {
            $productId = mysqli_real_escape_string($this->db->link,$productId);
            $customer_id = mysqli_real_escape_string($this->db->link,$customer_id);

            $check_wishlist = "SELECT * FROM tbl_wishlist  WHERE productId = '$productId' AND customer_id = '$customer_id'";
            $result_check_wishlist = $this->db->select($check_wishlist);
            if($result_check_wishlist) {
                $msg = "<span class='error'>Product has Already been added to Wishlist</span>";
                return $msg;
            }else{
                $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
                $result = $this->db->select($query)->fetch_assoc();

                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];

                $query_insert = "INSERT INTO tbl_wishlist(productId,price,image,customer_id,productName) 
                VALUES('$productId','$price','$image','$customer_id','$productName')";
                $insert_wishlist = $this->db->insert($query_insert);
                if($insert_wishlist) {
                    $alert = "<span class='success'>Wishlist added successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Wishlist added fail</span>";
                    return $alert;
                }
            }
        }
        // Thêm slider
        public function insert_slider($data, $files) {
            $sliderName = mysqli_real_escape_string($this->db->link,$data['sliderName']);
            $type = mysqli_real_escape_string($this->db->link,$data['type']);

            //Kiểm tra hình ảnh và lấy hình ảnh cho vào folder 
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));

            $unique_image = substr(md5(time()), 0, 10).".".$file_ext;
            $upload_image = "uploads/".$unique_image;

            if($sliderName == "" || $type == "" ) {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else{
                //Trường hợp người dùng chọn ảnh
                if(!empty($file_name)){
                    if($file_size> 20480000){
                       $alert = "<span class='error'>Image Size should be less than 2MB!</span>";
                       return $alert;
                    }    
                    else if(in_array($file_ext,$permited) === false)
                    {
                        $alert = "<span class='error'>You can upload only:".implode(',',$permited)."</span>";
                        return $alert;
                    }
                    move_uploaded_file($file_temp,$upload_image);
                    $query = "INSERT INTO tbl_slider(sliderName,type,slider_image) 
                              VALUES('$sliderName','$type','$unique_image')";
                    $result = $this->db->insert($query);
                    if($result) {
                        $alert = "<span class='success'>Insert Slider successfully</span>";
                        return $alert;
                    }
                    else{
                        $alert = "<span class='error'>Insert Slider fail</span>";
                        return $alert;
                    }
                    
                }
            }
        }
        // Hiển thị slider
        public function show_slider() {
            $query = "SELECT * FROM tbl_slider where type = '1' ORDER BY sliderId desc";
            $result = $this->db->select($query);
            return $result;
        }
        // Hiển thị danh sách slider
        public function show_slider_list() {
            $query = "SELECT * FROM tbl_slider  ORDER BY sliderId desc";
            $result = $this->db->select($query);
            return $result;
        }
        // Hiển thị sản phẩm
        public function show_product(){
            $query = "
            SELECT tbl_product.*, tbl_category.catName
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
            order by tbl_product.productId asc";
            $result = $this->db->select($query);
            return $result;
        }
        // Cập nhật kiểu slider (0:1)
        public function update_type_slider($id,$type) {
            $type = mysqli_real_escape_string($this->db->link,$type);
            $query = "UPDATE tbl_slider SET type = '$type' where sliderId = '$id'";
            $result = $this->db->update($query);
            return $result;
            
        }
        // Cập nhật sản phẩm
        public function update_product($data,$file,$id) {
            $productName = mysqli_real_escape_string($this->db->link,$data['productName']);
            $category = mysqli_real_escape_string($this->db->link,$data['category']);
            $product_desc = mysqli_real_escape_string($this->db->link,$data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link,$data['price']);
            $type = mysqli_real_escape_string($this->db->link,$data['type']);
            $status_product = mysqli_real_escape_string($this->db->link,$data['status_product']);
            //Kiểm tra hình ảnh và lấy hình ảnh cho vào folder 
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));

            $unique_image = substr(md5(time()), 0, 10).".".$file_ext;
            $upload_image = "uploads/".$unique_image;

            if($productName == "" || $category == ""  || $product_desc == "" || $price == "" || $type == "" || $status_product == "" ) {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else{
                //Trường hợp người dùng chọn ảnh
                if(!empty($file_name)){
                    if($file_size > 204800){
                       $alert = "<span class='error'>Image Size should be less than 2MB!</span>";
                       return $alert;
                    }    
                    else if(in_array($file_ext,$permited) === false)
                    {
                        $alert = "<span class='error'>You can upload only:".implode(',',$permited)."</span>";
                        return $alert;
                    }
                    move_uploaded_file($file_temp,$upload_image);
                    $query = "UPDATE tbl_product SET 
                    productName = '$productName', 
                    catId = '$category', 
                    type = '$type', 
                    status_product = '$status_product',
                    price = '$price', 
                    image = '$unique_image', 
                    product_desc = '$product_desc'
                                        
                    WHERE productId = '$id'";
                }
                else{
                    $query = "UPDATE tbl_product SET 
                    productName = '$productName', 
                    catId = '$category', 
                    type = '$type', 
                    status_product = '$status_product', 
                    price = '$price', 
                    product_desc = '$product_desc'
                                        
                    WHERE productId = '$id'";
                }
                $result = $this->db->update($query);
                if($result) {
                    $alert = "<span class='success'>Update Product successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Update Product fail</span>";
                    return $alert;
                }
            }
        }
        // Xóa slider
        public function del_slider($id) {
            $query = " DELETE FROM tbl_slider where sliderId = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Delete Slider successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class='error'>Delete Slider fail</span>";
                return $alert;
            }
        }
        // Xóa sản phẩm chỉ định
        public function del_product($id) {
            $query = " DELETE FROM tbl_product where productId = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Delete Product successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class='error'>Delete Product fail</span>";
                return $alert;
            }
        }
        // Xóa sản phẩm trong wishlist
        public function del_wishlist($proid,$customer_id) {
            $query = " DELETE FROM tbl_wishlist where productId = '$proid' AND customer_id = '$customer_id'";
            $result = $this->db->delete($query);
            return $result;
        }
        // Xóa sản phẩm trong compare
        public function del_compare($proid,$customer_id) {
            $query = " DELETE FROM tbl_compare where productId = '$proid' AND customer_id = '$customer_id'";
            $result = $this->db->delete($query);
            return $result;
        }
        // Lấy sản phẩm từ id
        public function getproductbyId($id) {
            $query = "SELECT * FROM tbl_product where productId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }
        // Lấy sản phẩm đặc trưng (thịnh hành)
        public function getproduct_promotion(){
            $query = "
            SELECT tbl_product.*, tbl_category.mode
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
	        WHERE tbl_product.type = '1' AND tbl_product.status_product = '1' AND tbl_category.mode = '1'
            order by tbl_product.productId desc LIMIT 12";
            $result = $this->db->select($query);
            return $result;
        } 
        // Lấy sản phẩm mới 
        public function getproduct_new(){
            $query = "
            SELECT tbl_product.*, tbl_category.mode
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
	        WHERE tbl_product.type = '0' AND tbl_product.status_product = '1' AND tbl_category.mode = '1'
            order by tbl_product.productId desc LIMIT 12";
            $result = $this->db->select($query);
            return $result;
        } 
        //Lay san pham tu catId
        public function getproduct_relation($id) {
            $query = "SELECT * FROM tbl_product where productId = '$id'";
            $result = $this->db->select($query)->fetch_assoc();
            $catId = $result['catId'];
            $query2 = "SELECT * FROM tbl_product where catId = '$catId'";
            $result2 = $this->db->select($query2);
            return $result2;
        }
        //Lay san pham tu catId
        public function getproductbycatId($id) {
            $query = "SELECT * FROM tbl_product where catId = '$id' and status_product ='1'";
            $result = $this->db->select($query);
            return $result;
        }
        // Lấy toàn bộ sản phẩm phân loại và phân trang
        public function getproductbycatId_pagination($id){
            $sp_tungtrang = 9;
            if(!isset($_GET['trang'])) {
                $trang = 1;
            }
            else {
                $trang = $_GET['trang'];
            }
            $tung_trang = ($trang-1)*$sp_tungtrang;
            $query = "SELECT * FROM tbl_product where catId = '$id' and status_product ='1' LIMIT $tung_trang,$sp_tungtrang"; 
            $result = $this->db->select($query);
            return $result;
        } 
        // Lấy toàn bộ sản phẩm và phân trang
        public function getproduct_pagination(){
            $sp_tungtrang = 9;
            if(!isset($_GET['trang'])) {
                $trang = 1;
            }
            else {
                $trang = $_GET['trang'];
            }
            $tung_trang = ($trang-1)*$sp_tungtrang;
            $query = "SELECT * FROM tbl_product where status_product ='1' LIMIT $tung_trang,$sp_tungtrang"; 
            $result = $this->db->select($query);
            return $result;
        } 
        // Lấy toàn bộ sản phẩm giới hạn 8 
        public function get_all_product(){
            $query = "
            SELECT tbl_product.*, tbl_category.mode
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
	        WHERE tbl_product.status_product = '1' AND tbl_category.mode = '1'
            order by tbl_product.productId asc LIMIT 8";
            $result = $this->db->select($query);
            return $result;
        } 

        // Lấy toàn bộ sản phẩm
        public function get_all_product_shop(){
            $query = "
            SELECT tbl_product.*, tbl_category.mode
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
	        WHERE tbl_product.status_product = '1' AND tbl_category.mode = '1'
            order by tbl_product.productId asc ";
            $result = $this->db->select($query);
            return $result;
        } 

        //Lấy chi tiết sản phẩm
        public function get_details($id){
            $query = "SELECT * FROM tbl_product where productid = '$id' order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        } 
        // Lấy tất cả sản phẩm từ bảng compare từ chính người dùng đang đăng nhập
        public function get_compare($customer_id){
            $query = "SELECT * FROM tbl_compare where customer_id = '$customer_id' order by id desc";
            $result = $this->db->select($query);
            return $result;
        }
        // Lấy tất cả sản phẩm từ bảng wishlist từ chính người dùng đang đăng nhập
        public function get_wishlist($customer_id){
            $query = "SELECT * FROM tbl_wishlist where customer_id = '$customer_id' order by id desc";
            $result = $this->db->select($query);
            return $result;
        }
        // Lấy tất cả sản phẩm từ mới đến cũ
        public function sortbynewness(){
            $query = "SELECT * FROM tbl_product order by productid desc";
            $result = $this->db->select($query);
            return $result;
        }
        // Lấy tất cả giá sản phẩm từ thấp đến cao
        public function sortlowtohigh(){
            $query = "SELECT * FROM tbl_product order by price asc";
            $result = $this->db->select($query);
            return $result;
        }
        // Lấy tất cả giá sản phẩm từ cao đến thấp
        public function sorthightolow(){
            $query = "SELECT * FROM tbl_product order by price desc";
            $result = $this->db->select($query);
            return $result;
        }
        public function update_quantity($productId,$quantity) {
            $query_select = "SELECT * FROM tbl_product WHERE productId = '$productId'";    
            $result_select = $this->db->select($query_select)->fetch_assoc();

            $sl_nhap = $result_select['sl_nhap'];
            $sl_banra = $quantity + $result_select['sl_banra'];
            $sl_conlai = $sl_nhap - $sl_banra;

            if($sl_conlai != 0) {
                $query_update = "UPDATE tbl_product SET sl_banra = '$sl_banra', sl_conlai = '$sl_conlai' WHERE productId = '$productId'";
                $result_update =  $this->db->update($query_update);
            }else if($sl_conlai == 0){
                $query_update = "UPDATE tbl_product SET sl_banra = '$sl_banra', sl_conlai = '$sl_conlai', status_product = '0' WHERE productId = '$productId'";
                $result_update =  $this->db->update($query_update);
            }
            if($result_update) {
                $alert = "<span class='success'>Update successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class='error'>Update fail</span>";
                return $alert;
            }
        }
    }   
?>