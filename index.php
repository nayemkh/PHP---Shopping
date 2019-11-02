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
// Products
$products_file_contents = file_get_contents("products.json");
$products_array = json_decode($products_file_contents, true);

// Unique Products Array

$product_types_array = array_column($products_array, 'type'); // Getting only product types
$product_types = array_unique($product_types_array); // Removing duplicates

// Search

// if ($_POST['search']) { }
?>

<body>
    <div class="header-wrapper">
        <h1 class="page-header">Shop</h1>
    </div>
    <div class="main">
        <div class="filter-wrapper">
            <h2>Search and Filter</h2>
            <form action="index.php" method="POST">
                <input type="hidden" value="1" name="search">
                <input class="input search" name="keyword" type="text" placeholder="Search for an item">
                <select name="product-type">
                    <?php foreach ($product_types as $product_type) { ?>
                        <option value="<?= $product_type; ?>"><?= $product_type; ?></option>
                    <?php } ?>
                </select>
                <button class="main-button" type="submit">Search</button>
            </form>
        </div>
        <div class="intro">
            <h2 class="intro-header">Items</h2>
        </div>
        <div class="product-list">
            <?php foreach ($products_array as $product) { ?>
                <a class="product-wrapper" href="#">
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
                </a>
            <?php } ?>
            <?php  ?>
        </div>
    </div>
</body>

</html>