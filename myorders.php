<?php 
session_start();
$con=require_once 'dbConnect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Order Status </title>
<meta charset="utf-8">

<!-- Bootstrap core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">

<!-- Custom style -->
<link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>MY ORDERS</h1>
    <div class="col-12">
    <?php if(!isset($_SESSION['email'])){ 
    echo '<script>alert("Please login yourself before checkout!!")</script>';
     echo "<script>window.location = './login-page/login_type.html';</script>";
     
    ?>
                    
    <?php }else{ ?>
            <!-- Order items -->
            <div class="row col-lg-12">
                <table class="table table-hover cart">
                    <thead>
                        <tr>
                            <th width="10%"></th>
                            <th width="20%">Product</th>
                            <th width="8%">Price</th>
                            <th width="8%">Qty.</th>
                            <th width="8%">Total</th>
                            <th width="35%">Address</th>
                            <th width="30%">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php 
                    $arr= array();
                    $arr=$_SESSION['email'];
                    $name=$arr[0];
                    // Get order items from the database 

                    $statement = $con->query("SELECT  customers.*,order_items.*,orders.*,products.* from customers,orders,order_items,products where customers.id=orders.customer_id and order_items.order_id=orders.id and order_items.product_id=products.id and customers.full_name='".$name."';");
                    $result=array();
                    // $result = mysqli_fetch_all($statement); 
                    if($statement->num_rows > 0){ 
                        while($item = $statement->fetch_assoc()){
                            // print_r($item);
                            $price = $item['price']; 
                            $quantity = $item['quantity']; 
                            $sub_total = ($price*$quantity); 
                            $proImg = !empty($item['image'])?'images/'.$item['image']:'images/demo-img.png'; 
                    ?>
                            <tr>
                                <td><img src="<?php echo $proImg; ?>" style="width:40%;height:40%;" alt="..."></td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo CURRENCY_SYMBOL." ".$price; ?></td>
                                <td><?php echo $quantity; ?></td>
                            <td><?php echo CURRENCY_SYMBOL." ".$sub_total; ?></td>
                            <td><?php echo $item['address']; ?></td>
                            <td><?php echo $item['created']; ?></td>
                        </tr>
                    <?php } } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="col mb-2">
                <div class="row">
                    <div class="col-sm-12  col-md-6">
                        <a href="./index.php" class="btn btn-block btn-primary"><i class='bx bx-chevron-left'></i>Continue Shopping</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>