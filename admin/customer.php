<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    $filepath = realpath(dirname(__FILE__));
    // include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
	include_once($filepath.'/../classes/customer.php');
   
?>
<?php   
    if(isset($_GET['customerid']) && $_GET['customerid']!=NULL){ 
        $id = $_GET['customerid'];
    }
    else {
        echo "<script>window.location ='inbox.php'</script>";
    }
?>

    <div class="col-lg-10" >
    <div class="container border rounded" style="padding-bottom:14%">
        <div class="row">
        <div class="col-3"></div>
        <?php
            $cs = new customer();
            $get_customer = $cs->show_customers($id);
            if($get_customer) {
                while($result = $get_customer->fetch_assoc()){
        ?>
        <div class="mt-5 justify-content-center d-flex col-6"> 
                <table class="table table-borderless">	
                    <!-- Tên -->
                    <tr>
                        <td>Tên</td>      
                        <td>:</td>                     
                        <td>
                            <input  class="form-control" type="text" readonly="readonly" value="<?php echo $result['name'] ?>"  />
                        </td>
                    </tr>
                    <!-- Địa chỉ -->
                    <tr>
                        <td>Địa chỉ</td>      
                        <td>:</td>                     
                        <td>
                            <input class="form-control" type="text" readonly="readonly" value="<?php echo $result['address'] ?>"  />
                        </td>
                    </tr>
                    <!-- Số điện thoại -->
                    <tr>
                        <td>SĐT</td>      
                        <td>:</td>                     
                        <td>
                            <input class="form-control" type="text" readonly="readonly" value="<?php echo $result['phone'] ?>"  />
                        </td>
                    </tr>
                    <!-- Email -->
                    <tr>
                        <td>Email</td>      
                        <td>:</td>                     
                        <td>
                            <input class="form-control" type="text" readonly="readonly" value="<?php echo $result['email'] ?>"  />
                        </td>
                    </tr>					
                </table>
           
        <?php
                }
            }
        ?> 
        </div>
           
    </div>
        </div>
</div>

<?php include 'inc/footer.php';?>