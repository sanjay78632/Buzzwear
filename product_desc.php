<?php
include("dbconnect.php");
include 'navbar.php';

// Check if the product ID is set in the URL
if (!isset($_GET['id'])) {
    // Redirect back to the main page if the product ID is not set
    header('Location: index.php');
    exit();
}

// Get the product ID from the URL
$id = $_GET['id'];

// Fetch the product details from the database based on the product ID
$sql = "SELECT * FROM products WHERE id = $id";
$result = $db->query($sql);

// Check if a product was found with the specified ID
if ($result->num_rows == 0) {
    // Redirect back to the main page if no product was found
    header('Location: index.php');
    exit();
}

// Get the product details from the result set
$row = $result->fetch_assoc();
$proImg1 = !empty($row["image"]) ? 'images/' . $row["image"] : 'images/demo-img.png';
$proImg2 = !empty($row["image2"]) ? 'images/' . $row["image2"] : ''; // This will be empty if image2 doesn't exist
$proName = $row["name"];
$proDesc = $row["description"];
$product_price = $row["price"];

// Close the result set and database connection
$result->close();
$db->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .star {
            color: white;
            /* Default color */
        }
    </style>
</head>

<body>

    <main>
        <section class="product-info">
            <div class="container px-3 mt-3">
                <div class="row gx-3">
                    <div class="col-md-5">
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?php echo $proImg1; ?>" class="d-block w-100" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?php echo $proImg2; ?>" class="d-block w-100" alt="Second slide">
                                </div>

                                <!-- Add more carousel items here if you have additional images -->
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="fs-1 fw-bolder"><?php echo $proName; ?></div>
                        <div class="reviews-counter" id="rate-container">
                            <!-- JavaScript will generate the stars here -->
                        </div>
                        <div class="mt-1">Description:</div>
                        <div class="fs-4 text"><?php echo $proDesc; ?><p>Oversized t-shirt is a comfortable and stylish clothing item, featuring a spacious design and breathable fabric. Perfect for casual wear, outdoor activities. Stand out with bold colors and eye-catching patterns. Don't miss out on this must-have piece</p>
                        </div>
                        <div class="mt-1">Price: ₹<?php echo $product_price; ?></div> <!-- Display the product price here -->
                        <div class="row gx-3">
                            <div class="col-md-6">
                                <div class="size-selector">
                                    <label for="size-select" class="mb-4">SELECT SIZE:</label>
                                    <select id="size-select" class="form-select">
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="size-selector input-group d-flex flex-column">
                                <label for="quantity-input">SELECT QUANTITY:</label><br>
                                <div class="d-flex ">
                                <button class="btn btn-outline-secondary btn-danger text-white fs-6 me-1" type="button" id="decrease-btn">-</button>
                                <input type="number" id="quantity-input" class="form-control" value="1">
                                <button class="btn btn-outline-secondary btn-primary text-white fs-6 ms-1" type="button" id="increase-btn">+</button>
                                </div>
                            </div>
                        </div>
                        </div>

                        <a href="#" class="btn bg-dark btn-sm mt-3 text-white" onclick="addToCart(<?php echo $row['id']; ?>, document.getElementById('size-select').value, document.getElementById('quantity-input').value); return false;">Add to Cart</a>


                    </div>
                </div>
            </div>
        </section>
    </main>


    <!-- <script>
    function addToCart(productId, quantity) {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Define what happens on successful data submission
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Optionally, you can perform some action after adding to cart, such as showing a message to the user
                alert('Product added to cart successfully!');
            }
        };

        // Configure the request
        xhr.open("GET", "cartAction.php?action=addToCart&id=" + productId + "&quantity=" + quantity, true);

        // Send the request
        xhr.send();
    }
</script> -->

    <script>
        function addToCart(productId, size, quantity) {
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Define what happens on successful data submission
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Optionally, you can perform some action after adding to cart, such as showing a message to the user
            alert('Product added to cart successfully!');
        }
    };

    // Configure the request
    xhr.open("GET", "cartAction.php?action=addToCart&id=" + productId + "&size=" + size + "&quantity=" + quantity, true);

    // Send the request
    xhr.send();
}

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const decreaseBtn = document.getElementById('decrease-btn');
            const increaseBtn = document.getElementById('increase-btn');
            const quantityInput = document.getElementById('quantity-input');

            decreaseBtn.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value);
                if (quantity > 1) {
                    quantityInput.value = quantity - 1;
                }
            });

            increaseBtn.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value);
                quantityInput.value = quantity + 1;
            });
        });
    </script>



    <script>
        // Function to generate a random number between min and max (inclusive)
        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        // Function to create star elements based on a random rating
        function createRandomStars() {
            var container = document.getElementById("rate-container");
            var rating = getRandomInt(1, 5); // Generate a random rating between 1 and 5
            container.innerHTML = ""; // Clear previous content

            for (var i = 1; i <= 5; i++) {
                var star = document.createElement("i");
                star.className = "fas fa-star star";
                var labelText = i <= rating ? i + " star" : i + " stars"; // Generate text based on rating
                star.title = labelText; // Set title attribute for tooltip
                container.appendChild(star);
                if (i <= rating) {
                    star.style.color = "yellow"; // Color filled stars yellow
                } else {
                    star.style.color = "black"; // Set color for unfilled stars
                }
            }
        }

        // Call the function when the page loads
        window.onload = createRandomStars;
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>