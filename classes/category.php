<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
    
?>


<?php
    class category 
    {
        private $db;
        private $fm;

        public function __construct() 
        {
            $this->db = new Database();
            $this->fm = new Format();
        } 

        //Thêm loại sản phẩm
        public function insert_category($catName)
        {
            $catName = $this->fm->validation($catName);
            $catName = mysqli_real_escape_string($this->db->link,$catName);
            

            if(empty($catName)) {
                $alert = "<span class='error'>Category must not be empty</span>";
                return $alert;
            }
            else {
                $query = "INSERT INTO tbl_category(catName) VALUES('$catName')";
                $result = $this->db->insert($query);
                if($result) {
                    $alert = "<span class='success'>Insert Category successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Insert Category fail</span>";
                    return $alert;
                }
            }
        }

        // Hiển thị loại sản phẩm
        public function show_category(){
            $query = "SELECT * FROM tbl_category order by catId desc";
            $result = $this->db->select($query);
            return $result;
        }

        // Cập nhật loại sản phẩm
        public function update_category($catName,$id) {

            $catName = $this->fm->validation($catName);
            $catName = mysqli_real_escape_string($this->db->link,$catName);
    
            $id = mysqli_real_escape_string($this->db->link,$id);

            if(empty($catName) ) {
                $alert = "<span class='error'>Category must not be empty</span>";
                return $alert;
            }
            else {
                $query = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id'";
                $result = $this->db->update($query);
                if($result) {
                    $alert = "<span class='success'>Update Category successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Update Category fail</span>";
                    return $alert;
                }
            }

        }

        // Xóa loại sản phẩm
        public function del_category($id) {
            $query = " DELETE FROM tbl_category where catId = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Delete Category successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class='error'>Delete Category fail</span>";
                return $alert;
            }
        }

        // Lấy loại sản phẩm từ Id
        public function getcatbyId($id) {
            $query = "SELECT * FROM tbl_category where catId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        // Hiển thị loại sản phẩm ra phía giao diện
        public function show_category_frontend(){
            $query = "SELECT * FROM tbl_category where mode = '1' order by catId desc";
            $result = $this->db->select($query);
            return $result;
        }

        // Cập nhật Mode category (0:1)
        public function update_mode_category($id,$mode) {
            $mode = mysqli_real_escape_string($this->db->link,$mode);
            $query = "UPDATE tbl_category SET mode = '$mode' where catId = '$id'";
            $result = $this->db->update($query);
            return $result;
            
        }

        // Lấy sản phẩm từ catId
        public function get_product_by_cat($id) {
            $query = "SELECT * FROM tbl_product where catId = '$id' order by catId desc LIMIT 8";
            $result = $this->db->select($query);
            return $result;
        }

        //Lấy tên sản phẩm từ loại sản phẩm (liên kết bảng)
        public function get_name_by_cat($id) {
            $query = "SELECT tbl_product.* , tbl_category.catName, tbl_category.catId
            FROM tbl_product,tbl_category 
            WHERE tbl_product.catId = tbl_category.catId AND tbl_category.catId = '$id' LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
    }
    
?>