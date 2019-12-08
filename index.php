<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <script data-search-pseudo-elements src="https://kit.fontawesome.com/25ad1fd958.js" crossorigin="anonymous"></script>
</head>

<?php

// Clear Search

if (isset($_POST['clear-search'])) {
    $_POST = [];
}

// Products
$products_file_contents = file_get_contents("products.json");
$products_array = json_decode($products_file_contents, true);

// Unique Products Array

$product_types_array = array_column($products_array, 'type'); // Getting only product types
$product_types = array_unique($product_types_array); // Removing duplicates

// Search

if (isset($_POST['search'])) {
    // Product Type Filter
    if (htmlentities($_POST['product-type'])) {
        $products_array = array_filter($products_array, function ($product) { // Filtering products array
            return $product['type'] == htmlentities($_POST['product-type']); // Return products with the same type
        });
    }
    // Keyword Filter

    $keyword = (htmlentities($_POST['keyword']));

    if ($keyword) {
        $names_array = array_column($products_array, 'name');  // Getting only product names
        foreach ($names_array as $name) { // Looping through names
            $match = stripos($name, $keyword); // Finding matches
            if (is_numeric($match)) { // if stripos not false
                $matches[] = $name; // Pushing matches into array
            }
        }
        if (!empty($matches)) {
            $products_array = array_filter($products_array, function ($product) use ($matches) { // Filtering products array
                if (in_array($product['name'], $matches)) { // If product name is found in matches array
                    return $product; // Return product
                }
            });
        }
    }
}

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
                    <option value="">Select a product type</option>
                    <?php
                    foreach ($product_types as $product_type) { ?>
                        <option value="<?= $product_type; ?>" <?php if (isset($_POST['product-type']) && htmlentities($_POST['product-type']) == $product_type) { ?> selected <?php } ?>><?= $product_type; ?></option>
                    <?php } ?>
                </select>
                <button class="main-button icon search" type="submit">Search</button>
                <?php if (isset($_POST['search'])) { ?>
                    <button type="submit" name="clear-search" class="main-button icon clear">Clear Search</a>
                    <?php } ?>
            </form>
        </div>
        <?php if (isset($_POST['search']) && htmlentities($_POST['product-type'])) { ?>
            <div class="active-filters-wrapper">
                <?php if (htmlentities($_POST['product-type'])) { ?>
                    <p>Filters:</p>
                    <span><?= htmlentities($_POST['product-type']) ?></span>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (isset($_POST['search']) && empty($matches) && $_POST['product-type'] == "") { ?>
            <div class="status-message">
                <p>Sorry, your search did not return any matches.</p>
            </div>
        <?php } ?>
        <div class="intro">
            <h2 class="intro-header">Items</h2>
        </div>
        <div class="product-list">
            <?php foreach ($products_array as $product) { ?>
                <a class="product-wrapper <?= strtolower($product['type']); ?>" href="#">
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
                </a>
            <?php } ?>
        </div>
    </div>
</body>

</html>