<?php
session_start();

if (!function_exists('get_cart_count')) {
    function get_cart_count() {
        if (!isset($_SESSION['cart'])) {
            return 0;
        }
        
        $cart_count = 0;
        foreach ($_SESSION['cart'] as $cart_item) {
            $cart_count += $cart_item['quantity'];
        }
        
        return $cart_count;
    }
}

// Function to remove an item from the cart
function remove_item($item_id) {
    if ($item_id && isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $cart_item) {
            if ($cart_item['id'] == $item_id) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
                return true; // Item removed successfully
            }
        }
    }
    return false; // Item not found in cart
}

// Handle removal if triggered
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $item_id = (int)$_POST['remove_id'];
    if (remove_item($item_id)) {
        header("Location: cart.php"); // Redirect to the cart page after successful removal
        exit;
    } else {
        echo "<div class='alert alert-danger'>Failed to remove the item. Please try again.</div>";
    }
}

// Get cart count
$cart_count = get_cart_count();

// Get product details
function getItemDetails($id) {
    $products = [
        ["id" => 1, "name" => "MAHAGRID T-shirt charcoal", "price" => 1170, "image" => "img/first-t.png", "image_hover" => "img/first-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
        ["id" => 2, "name" => "MAHAGRID T-shirt khaki", "price" => 1170, "image" => "img/second-t.png", "image_hover" => "img/second-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
        ["id" => 3, "name" => "MAHAGRID T-shirt white", "price" => 1170, "image" => "img/third-t.png", "image_hover" => "img/third-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
        ["id" => 4, "name" => "Don't Panic Pigment Tee", "price" => 1470, "image" => "img/fourth-t.png", "image_hover" => "img/fourth-s.png", "description" => "We make all reasonable efforts to accurately display the attributes of our products, including composition, size and colours. The colour you see will depend on your computer system."],
        ["id" => 5, "name" => "MAHAGRID Origin Logo Tee", "price" => 1190, "image" => "img/fifth-t.png", "image_hover" => "img/fifth-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
        ["id" => 6, "name" => "MAHAGRID Origin Logo Tee", "price" => 1190, "image" => "img/sixth-t.png", "image_hover" => "img/sixth-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
        ["id" => 7, "name" => "MAHAGRID Basic Logo Tee", "price" => 1269, "image" => "img/seventh-t.png", "image_hover" => "img/seventh-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
        ["id" => 8, "name" => "MAHAGRID Basic Logo Tee", "price" => 1269, "image" => "img/eighth-t.png", "image_hover" => "img/eighth-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."]
    ];

    foreach ($products as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    return null;
}

// Get item details
$item_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : null;
$item = null;

if ($item_id && isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cart_item) {
        if ($cart_item['id'] == $item_id) {
            $item = $cart_item;
            break;
        }
    }
}

if (!$item) {
    header("Location: cart.php");
    exit;
}

$product_details = getItemDetails($item_id);
if (!$product_details) {
    echo "<div class='alert alert-danger'>Product details not found. Please go back and try again.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Confirmation - Shopee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .product-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }
        .product-image-container img {
            width: 100%;
            height: auto;
            transition: opacity 0.5s ease-in-out;
        }
        .product-image-container .hover-image {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }
        .product-image-container:hover .normal-image {
            opacity: 0;
        }
        .product-image-container:hover .hover-image {
            opacity: 1;
        }
        .cart-badge {
            font-size: 1.2rem;
            color: #fff;
            background-color: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .cart-badge:hover {
            background-color: #0056b3;
        }
        .cart-count {
            background-color: #ffc107;
            color: #000;
            border-radius: 50%;
            font-size: 0.9rem;
            padding: 2px 7px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
<header class="header bg-dark py-3 mb-4 text-light" >
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" style="text-decoration: none;" class="text-light">
            <h1 class="h4 m-0">Shopee T-shirts</h1>
            </a>
            <button class="btn btn-info">
            <a href="cart.php" class="btn btn-info">
                <i class="bi bi-cart"></i> Cart
                <span class="cart-count text-bg-light"><?php echo $cart_count; ?></span>
            </a>
            </button>
        </div>
    </header>

    <div class="container" style="font-size: 50px; font-weight:500;">
        <p>Remove Item from Cart</p>
    </div>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body border border-danger-subtle">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?php echo htmlspecialchars($product_details['image']); ?>" alt="<?php echo htmlspecialchars($product_details['name']); ?>" class="img-fluid rounded shadow-sm">
                    </div>
                    <div class="col-md-8">
                        <h3><?php echo htmlspecialchars($product_details['name']); ?> 
                            <span class="badge bg-info">₱<?php echo number_format($product_details['price'], 2); ?></span>
                        </h3>
                        <p class="mt-3"><?php echo htmlspecialchars($product_details['description']); ?></p>
                        <p><strong>Size:</strong> <?php echo htmlspecialchars($item['size']); ?></p>
                        <p><strong>Quantity:</strong> <?php echo (int)$item['quantity']; ?></p>
                        <div class="mt-4">
                            <form method="POST" action="remove-confirm.php">
                                <input type="hidden" name="remove_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn btn-outline-dark me-2">
                                    <i class="bi bi-trash"></i> Confirm Product Removal
                                </button>
                                <a href="cart.php" class="btn btn-outline-danger">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
