<?php 
// Include the database connection file 
require_once 'dbConnect.php'; 

// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
// session_start();

// Fetch products from the database 
$sqlQ = "SELECT * FROM products ORDER BY RAND() LIMIT 3"; 
$stmt = $db->prepare($sqlQ); 
$stmt->execute(); 
$result = $stmt->get_result(); 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
    <title>Buzzwear</title>
    
    <!-- CSS-link -->
    <!--<link rel="stylesheet" href="style.css">-->
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo time(); ?>" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body>

    <header>
        <a href="index.php" class="logo"><img src="images/logo.png" alt=""></a>
        <?php if(!isset($_SESSION['email'])){ 
            $user="Guest";
        }else{
            $arr=array();
            $arr=$_SESSION['email'];
            $user=$arr[0];
            
        }?>
        <ul class="navmenu">
            <li><a href="./men.php">Men</a></li>
            <li><a href="./women.php">Women</a></li>
            <?php 
            if($user!="Guest"){
              echo '<li><a href="./logout.php">logout</a></li>';  
            }else{
                echo '<li><a href="./login-page/login_type.html">login</a></li>';  
            }
            ?>
            
             <li><a href="./myorders.php">My Orders</a></li>
        </ul>
        
        <div class="nav-icon">
            <!-- <a href="#"> <i class='bx bx-heart'></i></a> -->
            <a href="viewCart.php" title="View Cart"><i class='bx bx-cart' >(<?php echo($cart->total_items() > 0)?$cart->total_items():0; ?>)</i></a>
            <a href="login-page/login_type.html" ><i class='bx bx-user'><?php echo $user;?></i></a>
        </div>
    </header>