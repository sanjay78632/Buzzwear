<?php 
// Include the configuration file 
require_once 'config.php'; 
require('./razorpay-php-master/Razorpay.php');
use Razorpay\Api\Api;
 
// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
 
// If the cart is empty, redirect to the products page 
if($cart->total_items() <= 0){ 
    header("Location: ./index.php"); 
} 
 
// Get posted form data from session 
$postData = !empty($_SESSION['postData'])?$_SESSION['postData']:array(); 
unset($_SESSION['postData']); 
 
// Get status message from session 
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:''; 
if(!empty($sessData['status']['msg'])){ 
    $statusMsg = $sessData['status']['msg']; 
    $statusMsgType = $sessData['status']['type']; 
    unset($_SESSION['sessData']['status']); 
} 
?>
<?php
                    $username = "root";
                    $password = "root";
                    $hostname = "localhost";
                    $db="buzzwear";
                    //connection to the database
                    $con = mysqli_connect($hostname, $username, $password, $db);
                    $arr=array();
                    $arr=$_SESSION['email'];
                    $email=$arr[1];
                    $query = "SELECT * from login where email = '".$email."'";
                    $result = mysqli_query($con,$query);
                    $row=mysqli_fetch_assoc($result);
                    $name=$row['name'];
                    $email=$row['email'];
                    $contact=$row['contact'];
                    $haddress=$row['address'].', '.$row['city'].', '.$row['state'].', '.$row['country'];
    ?>
 
 

<!DOCTYPE html>
<html lang="en">
<head>
<title>Checkout - PHP Shopping Cart Tutorial</title>
<meta charset="utf-8">

<!-- Bootstrap core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<!-- Custom style -->
<link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php if(!isset($_SESSION['email'])){ 
    echo '<script>alert("Please login yourself before checkout!!")</script>';
     echo "<script>window.location = './login-page/login_type.html';</script>";
    ?>
                    
<?php }else{ ?>
<div class="container">
    <h1>CHECKOUT</h1>

    <div class="col-12">
        <div class="checkout">
            <div class="row">
                <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
                <div class="col-md-12">
                    <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                </div>
                <?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
                <div class="col-md-12">
                    <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
                </div>
                <?php } ?>
				
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your Cart</span>
                        <span class="badge badge-secondary badge-pill"><?php echo $cart->total_items(); ?></span>
                    </h4>
                    <ul class="list-group mb-3">
                    <?php 
                    if($cart->total_items() > 0){ 
                        // Get cart items from session 
                        $cartItems = $cart->contents(); 
                        foreach($cartItems as $item){ 
                    ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo $item["name"]; ?></h6>
                                <small class="text-muted"><?php echo CURRENCY_SYMBOL.$item["price"]; ?>(<?php echo $item["qty"]; ?>)</small>
                            </div>
                            <span class="text-muted"><?php echo CURRENCY_SYMBOL.$item["subtotal"]; ?></span>
                        </li>
                    <?php } } ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (<?php echo CURRENCY; ?>)</span>
                            <strong><?php echo CURRENCY_SYMBOL.$cart->total(); ?></strong>
                        </li>
                    </ul>
                    
                    <a href="index.php" class="btn btn-sm btn-info">+ add items</a>
                </div>
                
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Contact Details</h4>
                    <form method="post" action="cartAction.php">
                        <div class="row">
                            <div class=" mb-3">
                                <label for="first_name">Full Name</label>
                               <input type="text" class="form-control" name="full_name" value="<?php echo !empty($postData["full_name"])?$postData["full_name"]:$row['name'];?>" required readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                           <input type="email" class="form-control" name="email" value="<?php echo !empty($postData['email'])?$postData['email']:$row['email'];?>" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo !empty($postData['phone'])?$postData['phone']:$row['contact']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name">Address</label>
                          <input type="text" class="form-control" name="address" value="<?php echo !empty($postData["address"])?$postData["address"]:$haddress;?>" required readonly>
                        </div>
                        <input type="hidden" name="action" value="placeOrder"/>
                        <?php
                     include("./gateway-config.php");
                     
                    $api = new Api($keyId, $keySecret);
                    $webtitle="Buzzwear";
                    $displayCurrency='INR';
                    $orderData = [
                        'receipt'         => 3456,
                        'amount'          => $cart->total() * 100, // 2000 rupees in paise
                        'currency'        => 'INR',
                        'payment_capture' => 1 // auto capture
                    ];
                    $razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];
if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}
$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => $webtitle,
    "description"       => "Tron Legacy",
    "image"             => "https://s29.postimg.org/r6dj1g85z/daft_punk.jpg",
    "prefill"           => [
    "name"              => $name,
    "email"             => $email,
    "contact"           => $contact,
    ],
    "notes"             => [
    "address"           => $haddress,
    "merchant_order_id" => "12312321",
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];
    
                    ?>
                        <form action="verify.php" method="POST">
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $data['key']?>"
    data-amount="<?php echo $data['amount']?>"
    data-currency="INR"
    data-name="<?php echo $data['name']?>"
    data-image="<?php echo $data['image']?>"
    data-description="<?php echo $data['description']?>"
    data-prefill.name="<?php echo $data['prefill']['name']?>"
    data-prefill.email="<?php echo $data['prefill']['email']?>"
    data-prefill.contact="<?php echo $data['prefill']['contact']?>"
    data-notes.shopping_order_id="3456"
    data-order_id="<?php echo $data['order_id']?>"
    <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
    <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>
  >
  </script>
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden" name="shopping_order_id" value="3456">
</form>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>
</body>
</html>