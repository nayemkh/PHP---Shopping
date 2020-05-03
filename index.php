<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <script data-search-pseudo-elements src="https://kit.fontawesome.com/25ad1fd958.js" crossorigin="anonymous"></script>
</head>

<?php include('controller.php'); ?>

<body>
    <div class="header-wrapper">
        <h1 class="page-header">Shop</h1>
    </div>
    <div class="filter-wrapper">
        <h2>Search and Filter</h2>
        <form action="index.php" method="POST">
            <input type="hidden" value="1" name="search">
            <input class="input search" name="keyword" type="text" placeholder="Search for an item">
            <select name="product-type">
                <option value="">Select a product type</option>
                <?php
                foreach ($product_types as $product_type_item) { ?>
                    <option value="<?= $product_type_item; ?>" <?php if (isset($_POST['product-type']) && htmlentities($_POST['product-type']) == $product_type_item) { ?> selected <?php } ?>><?= $product_type_item; ?></option>
                <?php } ?>
            </select>
            <select name="sort">
                <option value="">Sort by..</option>
                <option value="price-high" <?php if (isset($_POST['sort']) && htmlentities($_POST['sort']) == "price-high") { ?> selected <?php } ?>>Price: highest to lowest</option>
                <option value="price-low" <?php if (isset($_POST['sort']) && htmlentities($_POST['sort']) == "price-low") { ?> selected <?php } ?>>Price: lowest to highest</option>
                <option value="weight-high" <?php if (isset($_POST['sort']) && htmlentities($_POST['sort']) == "weight-high") { ?> selected <?php } ?>>Weight: highest to lowest</option>
                <option value="weight-low" <?php if (isset($_POST['sort']) && htmlentities($_POST['sort']) == "weight-low") { ?> selected <?php } ?>>Weight: lowest to highest</option>
            </select>
            <button class="main-button icon search" type="submit">Search</button>
            <?php if (isset($search)) { ?>
                <button type="submit" name="clear-search" class="main-button icon clear">Clear Search</a>
                <?php } ?>
        </form>
    </div>
    <div class="main">
        <?php if (isset($search) && htmlentities($_POST['product-type']) || isset($search) && $keyword || isset($search) && htmlentities($_POST['sort']) ) { ?>
            <div class="active-filters-wrapper">
                <h2>Active Filters</h2>
                <?php if (htmlentities($_POST['product-type'])) { ?>
                    <span><?= $product_type; ?></span>
                <?php } ?>
                <?php if ($keyword) { ?>
                    <span><?= $keyword ?></span>
                <?php } ?>
                <?php if (htmlentities($_POST['sort'])) { ?>
                    <span><?= $sorting_message; ?></span>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (isset($search) && empty($matches) && htmlentities($_POST['product-type']) == "" && htmlentities($_POST['sort']) == "") { ?>
            <div class="status-message">
                <p>Sorry, your search did not return any matches.</p>
            </div>
        <?php } ?>
        <div class="intro">
            <h2 class="intro-header">Items</h2>
        </div>
        <div class="product-list">
            <?php
            if (!empty($products_array)) {
                foreach ($products_array as $product) { ?>
                    <a class="product-wrapper <?= strtolower($product['type']); ?>" href="#">
                        <h3 class="product-name"><?= $product['name']; ?></h3>
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
            <?php } ?>
        </div>
    </div>
</body>

</html>