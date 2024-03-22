<?php 
// Include the database connection file 
require_once 'dbConnect.php'; 
include'navbar.php';

// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
// session_start();

// Fetch products from the database 
$sqlQ = "SELECT * FROM products WHERE category='female'";
 
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
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
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
<section class="trending-product" id="trending">
        <div class="center-text">
            <h2>Women <span>products</span></h2>
        </div>
        <?php 
        if($result->num_rows > 0){ 
            $i=0;
            while($row = $result->fetch_assoc()){ 
                if($i==0){
                ?> <div class="row"> 
                <?php } $i++;
                $proImg = !empty($row["image"])?'images/'.$row["image"]:'images/demo-img.png'; 
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
                <?php if($i%3==0){
                echo '</div>';
                $i = 0; 
             }  }  $result->close();} ?>

        </section>
</body>