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
        <a href="#" class="logo"><img src="images/logo.png" alt=""></a>
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

    <section class="main-home">
        <div class="main-text">
            <h5>Summer Collection</h5>
            <h1>New Summer <br> Essentials 2024</h1>
            <p>Every Summer has its own stories!</p>

            <a href="#trending" class="main-btn">Shop Now <i class='bx bx-right-arrow-alt' ></i></a>
        </div>

        <div class="down-arrow">
            <a href="#trending" class="down"><i class='bx bx-down-arrow-alt' ></i></a>
        </div>
    </section>
   <!-- trending-products-section -->
<section class="trending-product" id="trending">
    <div class="center-text">
        <h2>Our Trending <span>products</span></h2>
    </div>
    <?php 
   
    

    if($result->num_rows > 0){ 
        $i = 0;
        while($row = $result->fetch_assoc()){ 
            if($i == 0){ ?>
                <div class="row"> 
            <?php } 
            $i++;
            $proImg = !empty($row["image"]) ? 'images/'.$row["image"] : 'images/demo-img.png'; 
            ?>
            <div class="col-sm-4">
                <img src="<?php echo $proImg; ?>" class="" alt="">

                <!-- <div class="heart-icon">
                    <i class='bx bx-heart'></i>
                </div>   -->
                <div class="float-end mt-2">
                    <a href="cartAction.php?action=addToCart&id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-primary">Add to Cart</a>
                    <a href="product_desc.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-secondary">Description</a>
                </div>
                <div class="price mt-2">
                    <h4><?php echo $row["name"]; ?></h4>
                    <p><?php echo CURRENCY_SYMBOL.' '.$row["price"]; ?></p>
                </div>
            </div>
            <?php 
            if($i % 3 == 0){
                echo '</div>';
                $i = 0; 
            }  
        }  
        $result->close();
    } 
    ?>
</section>

        <footer>
    <section class="contact">
        <div class="contact-info">
            <div class="first-info">
                <img src="images/logo.png" alt="">

                
                

                <!-- <div class="social-icon">
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-twitter' ></i></a>
                    <a href="#"><i class='bx bxl-instagram' ></i></a>
                    <a href="#"><i class='bx bxl-youtube' ></i></a>
                    <a href="#"><i class='bx bxl-linkedin' ></i></a>
                </div> -->
            </div>

            <!-- <div class="second-info">
                <h4>Support</h4>
                <p>Contact us</p>
                <p>Size Guide</p>
                <p>Shopping & Returns</p>
                
            </div> -->

            <!-- <div class="five">
                <h4>Shop</h4>
                <p>Men's Shopping</p>
                <p>Women's Shopping</p>
            </div> -->

            <!-- <div class="fourth-info">
                <h4>Company</h4>
                <p>About</p>
                <p>Blog</p>
                <p>Affiliate</p>
                <a href="./login-page/login_type.html"><p>Login</p></a>
            </div> -->

            <div class="five">
                <h4>Shop</h4>
                
                <a href="./men.php">Men's Shopping</a>
                <a href="./women.php">Women's Shopping</a>

            </div>
        </div>
    </section>

    <div class="end-text">
        <p>Copyright @2024. All Rights Reserved.Designd By BUZZWEAR team.</p>
    </div>

</footer>
        <script src="script.js"></script>
    </body>
    </html>