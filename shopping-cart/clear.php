<?php
session_start();
session_destroy(); 


session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Processed - Shopee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
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

        .alert {
            background-color: #e9f7ef;
            border: 1px solid #c3e6cb;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
                <span class="cart-count text-bg-light">0</span>
            </a>
            </button>
        </div>
    </header>

   
    <div class="container mt-5 text-center">
        <div class="alert alert-success py-5 rounded-3 shadow-sm">
            <div class="icon mb-3">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
            </div>
            <h2 class="fw-bold mb-3">Your Order is Completed!</h2>
            <p class="text-muted">Your order has been processed successfully. Thank you for shopping with us!</p>
            <a href="index.php" class="btn btn-primary mt-4 px-4 py-2">Continue Shopping</a>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>