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
    
    // hàm khởi tạo
    public function __construct() 
    {
        $this->db = new Database(); // tạo một đối tượng trong database
        $this->fm = new Format(); // đối tượng format
    } 
    // Tìm kiếm sản phẩm với từ khóa
    public function search_product($tukhoa) {
        $tukhoa = $this->fm->validation($tukhoa); //Kiểm tra là biến từ khóa đã có chưa
        // nếu từ khóa khác null
        if($tukhoa != NULL) {
            // truy vấn với hàm like product name
            $query = "SELECT * FROM tbl_product WHERE productName like '%$tukhoa%'";
            $result = $this->db->select($query);
            return $result;
        }
    }
    // Thêm sản phẩm
    public function insert_product($data,$files)
    {
        
        /**
        * - hàm mysqli_real_escape_string() bảo vệ các truy vẫn truyền vào sql
        * - tránh nguy cơ bị tấn công bởi mã độc.
        * - thay thế các ký tự đặt biệt trong chuổi thành thành một chuổi mới nhưng không làm thay đổi ý nghĩa 
        * chuổi truy vấn.
        */
        
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
        // lấy đuôi file
        $file_ext = strtolower(end($div));
        /*
        - time thời gian timestamp
        - mã hóa chuổi time dước dang băm mb5
        - substr lấy 10 phần tử từ 0 - 10 của chuỗi băm mb5
        */
        $unique_image = substr(md5(time()), 0, 10).".".$file_ext;
        $upload_image = "uploads/".$unique_image;
        
        // kiểm tra các tham số truyền vào có rổng ko
        if($productName == "" || $category == "" || $product_desc == "" || $price == "" || $sl_nhap == "" || $type == "" || $status_product == "" || $file_name = "") {
            $alert = "<span class='error'>Fields must not be empty</span>";
            return $alert;
        }
        // nếu không rổng
        else {
            // move file ảnh vào thư mục lưu trữ
            move_uploaded_file($file_temp,$upload_image);
            // lệnh sql insert vào database
            $query = "INSERT INTO tbl_product(productName,catId,product_desc,sl_nhap,sl_conlai,price,type,status_product,image) 
            VALUES('$productName','$category','$product_desc','$sl_nhap','$sl_nhap','$price','$type','$status_product','$unique_image')";
            $result = $this->db->insert($query);
            // nếu thêm vào thành công
            if($result) {
                $alert = "<span class='success'>Insert Product successfully</span>";
                return $alert;
            }
            // ngược lại không thành công 
            else{
                $alert = "<span class='error'>Insert Product fail</span>";
                return $alert;
            }
        }
    }
    // Thêm vào bảng so sánh sản phẩm
    public function insertCompare($productId,$customer_id) {
        /// format dữ liệu truy vấn sql
        $productId = mysqli_real_escape_string($this->db->link,$productId);
        $customer_id = mysqli_real_escape_string($this->db->link,$customer_id);
        // lệnh truy vấn compare kiểm tra sản phẩm trong danh sách
        $check_compare = "SELECT * FROM tbl_compare  WHERE productId = '$productId' AND customer_id = '$customer_id'";
        $result_check_compare = $this->db->select($check_compare);
        // nếu đã có sản phẩm trong danh sách so sánh
        if($result_check_compare) {
            $msg = "<span class='error'>Product has Already been added to Compare</span>";
            return $msg;
        }
        // nếu chưa có trong danh sách
        else{
            // truy vấn lấy sản phẩm theo id
            $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
            $result = $this->db->select($query)->fetch_assoc();
            // lấy name, price, ảnh sản phẩm
            $productName = $result['productName'];
            $price = $result['price'];
            $image = $result['image'];
            // lệnh sql insert sản phẩm vào compare
            $query_insert = "INSERT INTO tbl_compare(productId,price,image,customer_id,productName) 
            VALUES('$productId','$price','$image','$customer_id','$productName')";
            $insert_compare = $this->db->insert($query_insert);
            // nếu insert thành công 
            if($insert_compare) {
                $alert = "<span class='success'>Compare added successfully</span>";
                return $alert;
            }
            // thêm không thành công
            else{
                $alert = "<span class='error'>Compare added fail</span>";
                return $alert;
            }
        }
    }
    // Thêm vào yêu thích 
    public function insertWishlist($productId,$customer_id) {
        // format chuỗi đưa vào sql
        $productId = mysqli_real_escape_string($this->db->link,$productId);
        $customer_id = mysqli_real_escape_string($this->db->link,$customer_id);
        // kiểm tra sản phẩm đã có chưa
        $check_wishlist = "SELECT * FROM tbl_wishlist  WHERE productId = '$productId' AND customer_id = '$customer_id'";
        $result_check_wishlist = $this->db->select($check_wishlist);
        // nếu có
        if($result_check_wishlist) {
            $msg = "<span class='error'>Product has Already been added to Wishlist</span>";
            return $msg;
        }
        // chưa có
        else{
            // truy vấn sp theo id
            $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
            $result = $this->db->select($query)->fetch_assoc();
            // lấy name, price, ảnh sp
            $productName = $result['productName'];
            $price = $result['price'];
            $image = $result['image'];
            
            // chèn vào danh sách yêu thích
            $query_insert = "INSERT INTO tbl_wishlist(productId,price,image,customer_id,productName) 
            VALUES('$productId','$price','$image','$customer_id','$productName')";
            $insert_wishlist = $this->db->insert($query_insert);
            // nếu chèn thành công
            if($insert_wishlist) {
                $alert = "<span class='success'>Wishlist added successfully</span>";
                return $alert;
            }
            // chèn không thành công
            else{
                $alert = "<span class='error'>Wishlist added fail</span>";
                return $alert;
            }
        }
    }
    // Thêm slider phần banner
    public function insert_slider($data, $files) {
        // format dữ liệu trước khi đưa vào truy vấn
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
        
        // nếu ko có đối số 
        if($sliderName == "" || $type == "" ) {
            $alert = "<span class='error'>Fields must not be empty</span>";
            return $alert;
        }
        // ngược lại truyền đầy đủ name và type
        else{
            //Trường hợp người dùng chọn ảnh
            if(!empty($file_name)){
                // nếu file ảnh lớn hơn 2MB
                if($file_size> 20480000){
                    $alert = "<span class='error'>Image Size should be less than 2MB!</span>";
                    return $alert;
                }    
                // nếu không có đuôi file không tồn tại trong permited
                else if(in_array($file_ext,$permited) === false)
                {
                    $alert = "<span class='error'>You can upload only:".implode(',',$permited)."</span>";
                    return $alert;
                }
                // thêm vào thư mục uploads
                move_uploaded_file($file_temp,$upload_image);
                // lệnh sql chèn vào bảng slider
                $query = "INSERT INTO tbl_slider(sliderName,type,slider_image) 
                VALUES('$sliderName','$type','$unique_image')";
                $result = $this->db->insert($query);
                // nếu thêm thành công
                if($result) {
                    $alert = "<span class='success'>Insert Slider successfully</span>";
                    return $alert;
                }
                // không thêm thành công
                else{
                    $alert = "<span class='error'>Insert Slider fail</span>";
                    return $alert;
                }
                
            }
        }
    }
    // Hiển thị tất cả slider
    public function show_slider() {
        // lệnh truy vấn sql sấp xiếp id theo thứ tự giảm dần
        $query = "SELECT * FROM tbl_slider where type = '1' ORDER BY sliderId desc";
        $result = $this->db->select($query);
        return $result;
    }
    // Hiển thị danh sách slider
    public function show_slider_list() {
        // lệnh truy vấn sql sấp xiếp id theo thứ tự giảm dần
        $query = "SELECT * FROM tbl_slider  ORDER BY sliderId desc";
        $result = $this->db->select($query);
        return $result;
    }
    // Hiển thị sản phẩm
    public function show_product(){
        // truy vấn lấy sản phẩm join tới bản danh mục
        $query = "
        SELECT tbl_product.*, tbl_category.catName
        FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
        order by tbl_product.productId asc";
        $result = $this->db->select($query);
        return $result;
    }
    // Cập nhật kiểu slider (0:1)
    public function update_type_slider($id,$type) {
        // format dl
        $type = mysqli_real_escape_string($this->db->link,$type);
        // cập nhật lại slider bởi id
        $query = "UPDATE tbl_slider SET type = '$type' where sliderId = '$id'";
        $result = $this->db->update($query);
        return $result;
        
    }
    // Cập nhật sản phẩm
    public function update_product($data,$file,$id) {
        // format dl
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
        // kiểm tra dl có rổng hay ko
        if($productName == "" || $category == ""  || $product_desc == "" || $price == "" || $type == "" || $status_product == "" ) {
            $alert = "<span class='error'>Fields must not be empty</span>";
            return $alert;
        }
        else{
            //Trường hợp người dùng chọn ảnh
            if(!empty($file_name)){
                // nếu kích thước lớn hơn 2mb
                if($file_size > 204800){
                    $alert = "<span class='error'>Image Size should be less than 2MB!</span>";
                    return $alert;
                }    
                // nếu ko có đuôi file trong ds
                else if(in_array($file_ext,$permited) === false)
                {
                    $alert = "<span class='error'>You can upload only:".implode(',',$permited)."</span>";
                    return $alert;
                }
                // thêm ảnh vào thư mục
                move_uploaded_file($file_temp,$upload_image);
                // update product với id sp
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
                // cập nhật ko cập nhật lại file ảnh
                $query = "UPDATE tbl_product SET 
                productName = '$productName', 
                catId = '$category', 
                type = '$type', 
                status_product = '$status_product', 
                price = '$price', 
                product_desc = '$product_desc'
                
                WHERE productId = '$id'";
            }
            // nếu cập nhật thành công
            $result = $this->db->update($query);
            if($result) {
                $alert = "<span class='success'>Update Product successfully</span>";
                return $alert;
            }
            // ko cập nhật thành công
            else{
                $alert = "<span class='error'>Update Product fail</span>";
                return $alert;
            }
        }
    }
    // Xóa slider theo id
    public function del_slider($id) {
        // lệnh sql xóa slider với id
        $query = " DELETE FROM tbl_slider where sliderId = '$id'";
        $result = $this->db->delete($query);
        // nếu xóa thành công
        if($result) {
            $alert = "<span class='success'>Delete Slider successfully</span>";
            return $alert;
        }
        // nếu xóa ko thành công
        else{
            $alert = "<span class='error'>Delete Slider fail</span>";
            return $alert;
        }
    }
    // Xóa sản phẩm theo id
    public function del_product($id) {
        // lệnh sql xóa sp theo id
        $query = " DELETE FROM tbl_product where productId = '$id'";
        $result = $this->db->delete($query);
        // nếu xóa thành công
        if($result) {
            $alert = "<span class='success'>Delete Product successfully</span>";
            return $alert;
        }
        // nếu xóa không thành công
        else{
            $alert = "<span class='error'>Delete Product fail</span>";
            return $alert;
        }
    }
    // Xóa sản phẩm trong danh sách yêu thích
    public function del_wishlist($proid,$customer_id) {
        // lệnh sql xóa sp trong wishlist theo product id và customer id
        $query = " DELETE FROM tbl_wishlist where productId = '$proid' AND customer_id = '$customer_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    // Xóa sản phẩm trong ds so sánh
    public function del_compare($proid,$customer_id) {
        // lệnh sql xóa sp trong ds so sánh theo id sp và id người dùng
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
    // Lấy sản phẩm đặc trưng (thịnh hành) sản phẩm khuyến mãi (lấy 12 sp) 
    public function getproduct_promotion(){
        $query = "
        SELECT tbl_product.*, tbl_category.mode
        FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
        WHERE tbl_product.type = '1' AND tbl_product.status_product = '1' AND tbl_category.mode = '1'
        order by tbl_product.productId desc LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    } 
    // Lấy sản phẩm mới (lấy 12 sp mới nhất)
    public function getproduct_new(){
        $query = "
        SELECT tbl_product.*, tbl_category.mode
        FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
        WHERE tbl_product.type = '0' AND tbl_product.status_product = '1' AND tbl_category.mode = '1'
        order by tbl_product.productId desc LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    } 
    //Lay san pham tu catId (sp liên quan)
    public function getproduct_relation($id) {
        /// tìm sp theo id
        $query = "SELECT * FROM tbl_product where productId = '$id'";
        $result = $this->db->select($query)->fetch_assoc();
        // lấy id danh mục 
        $catId = $result['catId'];
        // lấy tất cả sp theo id danh mục 
        $query2 = "SELECT * FROM tbl_product where catId = '$catId'";
        $result2 = $this->db->select($query2);
        return $result2;
    }
    //Lay san pham theo id danh muc
    public function getproductbycatId($id) {
        $query = "SELECT * FROM tbl_product where catId = '$id' and status_product ='1'";
        $result = $this->db->select($query);
        return $result;
    }
    // Lấy toàn bộ sản phẩm phân loại và phân trang
    public function getproductbycatId_pagination($id){
        $sp_tungtrang = 9; // số lượng sp max trong 1 trang
        if(!isset($_GET['trang'])) {
            $trang = 1;
        }
        else {
            $trang = $_GET['trang'];
        }
        $tung_trang = ($trang-1)*$sp_tungtrang;
        // lệnh sql truy vấn sp theo id danh mục với limit số lượng sp từng trang với vị trí bắt đầu 
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
    // cập nhật lại số lượng sản phẩm 
    public function update_quantity($productId,$quantity) {
        // lấy sp theo id
        $query_select = "SELECT * FROM tbl_product WHERE productId = '$productId'";    
        $result_select = $this->db->select($query_select)->fetch_assoc();
        // lấy sl nhập
        $sl_nhap = $result_select['sl_nhap'];
        // số lượng bán ra = số lượng bán ra + số lượng vừa bán 
        $sl_banra = $quantity + $result_select['sl_banra'];
        // số lượng còn lại = số lượng nhập - sl bán ra
        $sl_conlai = $sl_nhap - $sl_banra;
        
        // nếu sp còn hàng
        if($sl_conlai != 0) {
            // cập nhật số lượng bán ra và sl còn lại
            $query_update = "UPDATE tbl_product SET sl_banra = '$sl_banra', sl_conlai = '$sl_conlai' WHERE productId = '$productId'";
            $result_update =  $this->db->update($query_update);
        }
        // nếu = 0 
        else if($sl_conlai == 0){
            // cập nhật số lượng bán ra và sl còn lại và cập nhật lại trạng thái sp
            $query_update = "UPDATE tbl_product SET sl_banra = '$sl_banra', sl_conlai = '$sl_conlai', status_product = '0' WHERE productId = '$productId'";
            $result_update =  $this->db->update($query_update);
        }
        // nếu cập nhật thành công
        if($result_update) {
            $alert = "<span class='success'>Update successfully</span>";
            return $alert;
        }
        // cập nhật không thành công
        else{
            $alert = "<span class='error'>Update fail</span>";
            return $alert;
        }
    }
}   
?>