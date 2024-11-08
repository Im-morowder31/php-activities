<?php
session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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



$cart_count = get_cart_count();

$items = [
    ["id" => 1, "name" => "MAHAGRID T-shirt charcoal", "price" => 1170, "image" => "img/first-t.png", "image_hover" => "img/first-s.png"],
    ["id" => 2, "name" => "MAHAGRID T-shirt khaki", "price" => 1170, "image" => "img/second-t.png", "image_hover" => "img/second-s.png"],
    ["id" => 3, "name" => "MAHAGRID T-shirt white", "price" => 1170, "image" => "img/third-t.png", "image_hover" => "img/third-s.png"],
    ["id" => 4, "name" => "Don't Panic Pigment Tee", "price" => 1470, "image" => "img/fourth-t.png", "image_hover" => "img/fourth-s.png"],
    ["id" => 5, "name" => "MAHAGRID Origin Logo Tee", "price" => 1190, "image" => "img/fifth-t.png", "image_hover" => "img/fifth-s.png"],
    ["id" => 6, "name" => "MAHAGRID Origin Logo Tee", "price" => 1190, "image" => "img/sixth-t.png", "image_hover" => "img/sixth-s.png"],
    ["id" => 7, "name" => "MAHAGRID Basic Logo Tee", "price" => 1269, "image" => "img/seventh-t.png", "image_hover" => "img/seventh-s.png"],
    ["id" => 8, "name" => "MAHAGRID Basic Logo Tee", "price" => 1269, "image" => "img/eighth-t.png", "image_hover" => "img/eighth-s.png"]
];


function get_cart_item_details($item_id) {
    global $items;
    foreach ($items as $item) {
        if ($item['id'] === $item_id) {
            return $item;
        }
    }
    return null;
}


$total_price = 0;


function updateCartQuantities($post_data) {
    if (isset($post_data['quantity'])) {
        foreach ($post_data['quantity'] as $id => $quantity) {
            
            foreach ($_SESSION['cart'] as &$cart_item) {
                if ($cart_item['id'] == $id) {
                    
                    $cart_item['quantity'] = min(100, max(1, (int)$quantity));
                }
            }
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateCartQuantities($_POST); 
    header("Location: cart.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Shopee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .cart-badge {
            position: relative;
            color: #fff;
            background-color: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
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
            padding: 4px 8px;
            margin-left: 8px;
        }
        .cart-table th, .cart-table td {
            vertical-align: middle;
        }
        .cart-image {
            width: 60px;
            height: auto;
            border-radius: 5px;
        }
        .alert {
            border: 1px solid #c6c6c6;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body style="background-color: whitesmoke;">
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


    <div class="container">
        <h2 class="mb-4">Shopee | Shopping Cart</h2>
        
        <?php if (empty($_SESSION['cart'])): ?>
           
            <div class="alert alert-secondary text-center py-4" role="alert">
                No item added to cart.
            </div>
            <div class="text-center">
                <a href="index.php" class="btn btn-primary btn-lg"><i class="bi bi-arrow-left"></i> Continue Shopping</a>
            </div>
        <?php else: ?>
           
            <form action="cart.php" method="POST">
                <table class="table table-hover table-bordered cart-table table-dark table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $cart_item): ?>
                            <?php
                                $item_details = get_cart_item_details($cart_item['id']);
                                if ($item_details):
                                    $item_total = $item_details['price'] * $cart_item['quantity'];
                                    $total_price += $item_total;
                            ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $item_details['image']; ?>" class="cart-image me-3 rounded shadow-sm" alt="<?php echo $item_details['name']; ?>">
                                        <span><?php echo $item_details['name']; ?></span>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo isset($cart_item['size']) ? $cart_item['size'] : 'N/A'; ?></td>
                                <td class="text-center">
                                    <input type="number" name="quantity[<?php echo $cart_item['id']; ?>]" 
                                        value="<?php echo $cart_item['quantity']; ?>" 
                                        min="1" max="100" 
                                        class="form-control d-inline-block text-center" 
                                        style="width: 70px;">
                                </td>

                                <td>₱<?php echo number_format($item_details['price'], 2); ?></td>
                                <td>₱<?php echo number_format($item_total, 2); ?></td>
                                <td class="text-center">
                                <a href="remove-confirm.php?product_id=<?php echo $cart_item['id']; ?>" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>

              
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Total: <span class="text-dark">₱<?php echo number_format($total_price, 2); ?></span></h4>
                    <div>
                        <a href="index.php" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Continue Shopping</a>
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-arrow-repeat"></i> Update Cart</button>
                        <a href="clear.php" class="btn btn-info"><i class="bi bi-credit-card"></i> Checkout</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>