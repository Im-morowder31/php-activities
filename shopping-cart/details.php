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


$items = [
    ["id" => 1, "name" => "MAHAGRID T-shirt charcoal", "price" => 1170, "image" => "img/first-t.png", "image_hover" => "img/first-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
    ["id" => 2, "name" => "MAHAGRID T-shirt khaki", "price" => 1170, "image" => "img/second-t.png", "image_hover" => "img/second-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
    ["id" => 3, "name" => "MAHAGRID T-shirt white", "price" => 1170, "image" => "img/third-t.png", "image_hover" => "img/third-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
    ["id" => 4, "name" => "Don't Panic Pigment Tee", "price" => 1470, "image" => "img/fourth-t.png", "image_hover" => "img/fourth-s.png", "description" => "We make all reasonable efforts to accurately display the attributes of our products, including composition, size and colours. The colour you see will depend on your computer system."],
    ["id" => 5, "name" => "MAHAGRID Origin Logo Tee", "price" => 1190, "image" => "img/fifth-t.png", "image_hover" => "img/fifth-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
    ["id" => 6, "name" => "MAHAGRID Origin Logo Tee", "price" => 1190, "image" => "img/sixth-t.png", "image_hover" => "img/sixth-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
    ["id" => 7, "name" => "MAHAGRID Basic Logo Tee", "price" => 1269, "image" => "img/seventh-t.png", "image_hover" => "img/seventh-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."],
    ["id" => 8, "name" => "MAHAGRID Basic Logo Tee", "price" => 1269, "image" => "img/eighth-t.png", "image_hover" => "img/eighth-s.png", "description" => "‘MAHA’ REPRESENTS THE GREATNESS AND ‘GRID’ MEANS GRID PATTERN. Combining the Indonesian word “maha”, which means greatness and “grid”, which refers to a grid pattern, the blended word has the meaning of “great milestone”."]
];


$item_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$item = null;


foreach ($items as $product) {
    if ($product['id'] === $item_id) {
        $item = $product;
        break;
    }
}


if (!$item) {
    header("Location: index.php");
    exit;
}


$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cart_item) {
        $cart_count += $cart_item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $item['name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
    }

    .product-image {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        cursor: pointer;
        height: 450px;
        width: 100%;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.5s ease, transform 0.3s ease;
    }

    .product-image img.hover {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
    }

    .product-image:hover img.normal {
        opacity: 0;
    }

    .product-image:hover img.hover {
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
        <p>Product Details</p>
    </div>
<div class="container mt-5">
    <div class="row border border-top-0 border-start-0 border-end-0 border-info">
        <div class="col-md-5">
            <div class="product-image mb-4">
                <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="normal shadow-sm rounded">
                <img src="<?php echo $item['image_hover']; ?>" alt="<?php echo $item['name']; ?>" class="hover shadow-sm rounded">
            </div>
        </div>
        <div class="col-md-7">
            <h2 class="fw-bold"><?php echo $item['name']; ?> <span class="badge bg-info">₱<?php echo number_format($item['price'], 2); ?></span></h2>
            <p class="text-muted mt-3"><?php echo $item['description']; ?></p>

            <form action="confirm.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                
                <h4 class="mt-4">Select Size:</h4>
                <div class="mb-3">
                    <label class="form-check-label me-2"><input type="radio" name="size" value="XS" checked> XS</label>
                    <label class="form-check-label me-2"><input type="radio" name="size" value="SM"> SM</label>
                    <label class="form-check-label me-2"><input type="radio" name="size" value="MD"> MD</label>
                    <label class="form-check-label me-2"><input type="radio" name="size" value="LG"> LG</label>
                    <label class="form-check-label"><input type="radio" name="size" value="XL"> XL</label>
                </div>

                <h4>Enter Quantity:</h4>
                <input type="number" class="form-control w-25 mb-3" name="quantity" value="1" min="1" max="100">


                <button type="submit" class="btn btn-outline-success"><i class="bi bi-check-circle"></i> Confirm Product Purchase</button>
                <a href="index.php" class="btn btn-outline-secondary ms-2"><i class="bi bi-arrow-left"></i> Cancel</a>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>