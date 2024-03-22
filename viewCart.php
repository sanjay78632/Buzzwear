<?php
// Include the configuration file 
require_once 'config.php';
session_start();

// Initialize shopping cart class 
include_once 'Cart.class.php';
$cart = new Cart;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Cart </title>
    <meta charset="utf-8">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Custom style -->
    <link href="css/style.css" rel="stylesheet">
    <!--Boxicon Icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!--Fontawesome-->
    <link rel="stylesheet" href="https://kit.fontawesome.com/eebed9b8f1.css" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/eebed9b8f1.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <script>
        function updateCartItem(obj, id) {
            $.get("cartAction.php", {
                action: "updateCartItem",
                id: id,
                qty: obj.value
            }, function(data) {
                if (data == 'ok') {
                    location.reload();
                } else {
                    alert('Cart update failed, please try again.');
                }
            });
        }
    </script>
</head>

<body>

    <div class="container">
        <h1>SHOPPING CART</h1>
        <div class="row">
            <div class="cart">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped cart">
                            <thead>
                                <tr>
                                    <th width="10%">Image</th>
                                    <th width="25%">Product</th>
                                    <th width="15%">Size</th>
                                    <th width="15%">Price</th>
                                    <th width="15%">Quantity</th>
                                    <th width="20%">Total</th>
                                    <th width="5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($cart->total_items() > 0) {
                                    // Get cart items from session 
                                    $cartItems = $cart->contents();
                                    foreach ($cartItems as $item) {
                                        $proImg = !empty($item["image"]) ? 'images/' . $item["image"] : 'images/demo-img.png';
                                ?>
                                        <tr>
                                            <td><img src="<?php echo $proImg; ?>" style="width:40%;height:40%;" alt="Product Image"></td>
                                            <td><?php echo $item["name"]; ?></td>
                                            <td><?php echo isset($item["size"]) ? $item["size"] : "N/A"; ?></td>
                                            <td><?php echo CURRENCY_SYMBOL . $item["price"] . ' ' . CURRENCY; ?></td>
                                            <td><input class="form-control" type="number" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')" /></td>
                                            <td><?php echo CURRENCY_SYMBOL . $item["subtotal"] . ' ' . CURRENCY; ?></td>
                                            <td><button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to remove cart item?')?window.location.href='cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>':false;" title="Remove Item"><i class="fa-solid fa-trash"></i> </button> </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">
                                            <p>Your cart is empty.....</p>
                                        </td>
                                    <?php } ?>
                            </tbody>
                            <?php if ($cart->total_items() > 0) { ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><strong>Cart Total</strong></td>
                                        <td><strong><?php echo CURRENCY_SYMBOL . $cart->total() . ' ' . CURRENCY; ?></strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="col mb-2">
                    <div class="row">
                        <div class="col-sm-12  col-md-6">
                            <a href="index.php" class="btn btn-block btn-secondary"><i class='bx bx-chevron-left'></i> Continue Shopping</a>
                        </div>
                        <div class="col-sm-12 col-md-6 text-right">
                            <?php if ($cart->total_items() > 0) { ?>
                                <a href="checkout.php" class="btn btn-block btn-primary">Proceed to Checkout <i class="fa-solid fa-right-to-bracket"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</body>

</html>