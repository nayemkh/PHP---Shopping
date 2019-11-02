<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<?php

// // Product Class
// class Product
// {
//     public static $products_list = ['Hey'];
//     var $product_name;
//     var $product_price;
//     var $product_weight;
//     var $product_id;

//     // Product Constructor

//     public function __construct($a_name, $a_price, $a_weight, $a_id)
//     {
//         $this->product_name = $a_name;
//         $this->product_price = $a_price;
//         $this->product_weight = $a_weight;
//         $this->product_id = $a_id;
//         Product::$products_list[] = $this;
//     }
// }

// // Products
// $rice = new Product("Rice", 10, 10000, 001);
// $chocolate = new Product("Chocolate", 0.50, 45, 002);
// $jelly = new Product("Jelly", 1.20, 60, 003);
// $strawberries = new Product("Strawberries", 2.50, 200, 004);
// $water_bottle = new Product("Water Bottle", 1, 150, 005);
// var_dump($products_list);

$products_file_contents = file_get_contents("products.json");
$products_array = json_decode($products_file_contents, true);
?>

<body>
    <div class="header-wrapper">
        <h1 class="page-header">Shop</h1>
    </div>
    <div class="main">
        <div class="intro">
            <h2 class="intro-header">Items</h2>
        </div>
        <div class="product-list">
            <?php foreach ($products_array as $product) { ?>
                <div class="product-wrapper">
                    <h2 class="product-name"><?= $product['name']; ?></h2>
                    <p class="product-price"><strong>Price:</strong> £<?= number_format((float) $product['price'], 2, '.', ''); ?></p>
                    <p class="product-weight"> <strong>Weight: </strong>
                        <?php if ($product['weight'] >= 1000) {
                                echo $product['weight'] / 1000 . 'KG';
                            } else {
                                echo $product['weight'] . 'g';
                            } ?>
                    </p>
                    <p class="product-id"><strong>Product ID:</strong> <?= $product['id']; ?></p>
                    <p class="product-type"><?= $product['type']; ?></p>
                </div>
            <?php } ?>
            <?php  ?>
        </div>
    </div>
</body>

</html>