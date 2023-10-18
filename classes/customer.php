<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
?>


<?php
    class customer
    {
        private $db;
        private $fm;

        public function __construct() 
        {
            $this->db = new Database();
            $this->fm = new Format();
        } 

        // Thêm bình luận
        public function insert_binhluan($customer_id,$id) {
            $customer_id = mysqli_real_escape_string($this->db->link,$customer_id);
            $product_id = mysqli_real_escape_string($this->db->link,$id);
            $binhluan = $_POST['binhluan'];

            if($binhluan == "") {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else{
                $query = "INSERT INTO tbl_comment(product_id,customer_id,binhluan) 
                            VALUES('$product_id','$customer_id','$binhluan')";
                $result = $this->db->insert($query);
                if($result) {
                    $alert = "<span class='success'>Bình luận sẽ được admin kiểm duyệt</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Bình luận không thành công</span>";
                    return $alert;
                }
            }
        }
        
        //Thêm khách hàng
        public function insert_customers($data){
            $name = mysqli_real_escape_string($this->db->link,$data['name']);
            $address = mysqli_real_escape_string($this->db->link,$data['address']);
            $phone = mysqli_real_escape_string($this->db->link,$data['phone']);
            $email = mysqli_real_escape_string($this->db->link,$data['email']);
            $password = mysqli_real_escape_string($this->db->link,md5($data['password'])); //Mã hóa

            if($name == "" || $address == "" || $phone == "" || $email == "" || $password == "" ) {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else {
                //Kiểm tra email đã tồn tại hay chưa
                $check_email = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
                $result_check = $this->db->select($check_email);
                if($result_check) {
                    $alert = "<span class='error'>Email existed !Please enter another email!!</span>";
                    return $alert;
                }
                else{
                    $query = "INSERT INTO tbl_customer(name,address,phone,email,password) 
                              VALUES('$name','$address','$phone','$email','$password')";
                    $result = $this->db->insert($query);
                    if($result) {
                        $alert = "<span class='success'>Regist custommer successfully</span>";
                        return $alert;
                    }
                    else{
                        $alert = "<span class='error'>Regist customer fail</span>";
                        return $alert;
                    }
                }
            }
        }

        //Đăng nhập khách hàng
        public function login_customers($data) {
            $email = mysqli_real_escape_string($this->db->link,$data['email']);
            $password = mysqli_real_escape_string($this->db->link,md5($data['password']));

            if($email == "" || $password == "" ) {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else {
                $check_login = "SELECT * FROM tbl_customer WHERE email = '$email' and password = '$password' ";
                $result_check = $this->db->select($check_login);

                if($result_check) {
                    $value = $result_check->fetch_assoc();
                    Session::set('customer_login',true);
                    Session::set('customer_id',$value['id']);
                    Session::set('customer_name',$value['name']);
                    echo "<script>window.location ='index.php'</script>"; //note
                }
                else{
                    $alert = "<span class='error'>Email or Password doesn't match</span>";
                    return $alert;
                }
            }
        }

        // Hiển thị khách hàng
        public function show_customers($id){
            $query = "SELECT * FROM tbl_customer WHERE id = '$id' ";
            $result= $this->db->select($query);
            return $result;
        }

         // Hiển thị khách hàng
         public function show_all_customers(){
            $query = "SELECT * FROM tbl_customer";
            $result= $this->db->select($query);
            return $result;
        }

        // Cập nhật khách hàng
        public function update_customers($data,$id) {
            $name = mysqli_real_escape_string($this->db->link,$data['name']);            
            $email = mysqli_real_escape_string($this->db->link,$data['email']);
            $address = mysqli_real_escape_string($this->db->link,$data['address']);
            $phone = mysqli_real_escape_string($this->db->link,$data['phone']);
    

            if($name == "" || $email == "" || $address == ""  || $phone == "" ) {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            
            else{
                $query = "UPDATE tbl_customer SET name='$name',email='$email',address='$address',phone='$phone' WHERE id = '$id'";
                           
                $result = $this->db->insert($query);
                if($result) {
                    $alert = "<span class='success'>Update custommer successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Update customer fail</span>";
                    return $alert;
                }
            }
        }
        public function updatePassword($data) {
            $email = mysqli_real_escape_string($this->db->link,$data['email']);
            $oldpassword = mysqli_real_escape_string($this->db->link,md5($data['oldpassword']));
            $newpassword = mysqli_real_escape_string($this->db->link,md5($data['newpassword']));

            if($email == "" || $oldpassword == "" || $newpassword == "" ) {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else {
                //Email đã được kiểm tra trước khi đăng ký => duy nhất
                $check_account = "SELECT * FROM tbl_customer WHERE email = '$email' and password = '$oldpassword'";
                $result_check = $this->db->select($check_account);
                if($result_check){
                    $query = "UPDATE tbl_customer SET password = '$newpassword' WHERE email = '$email' and password = '$oldpassword'";
                    $result = $this->db->update($query);
                    if($result) {
                        $alert = "<span class='success'>Change password successfully</span>";
                        return $alert;
                    }
                    else{
                        $alert = "<span class='error'>Change password fail</span>";
                        return $alert;
                    }
                }
                else{
                    $alert = "<span class='error'>Email or password is wrong</span>";
                    return $alert;
                }                
            }
        }
        public function show_name($id){
            $query = "
            SELECT tbl_comment.*, tbl_customer.name

            FROM tbl_comment INNER JOIN tbl_customer ON tbl_comment.customer_id = tbl_customer.id
            
            where tbl_comment.product_id = $id;
            ";

            $result = $this->db->select($query);
            return $result;
        }

        public function show_comment(){
            $query = "
            SELECT tbl_comment.*, tbl_customer.name,tbl_product.productName

            FROM tbl_comment INNER JOIN tbl_customer ON tbl_comment.customer_id = tbl_customer.id
            INNER JOIN tbl_product ON tbl_comment.product_id = tbl_product.productId";

            $result = $this->db->select($query);
            return $result;
        }


        public function del_comment($id) {
            $query = " DELETE FROM tbl_comment where binhluan_id = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Delete Comment successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class='error'>Delete Comment fail</span>";
                return $alert;
            }
        }

    }
?>

