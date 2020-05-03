<?php

// Clear Search

if (isset($_POST['clear-search'])) {
    $_POST = [];
}

// Products
$products_file_contents = file_get_contents("products.json");
$products_array = json_decode($products_file_contents, true);

// Isolating fields

$names_array = array_column($products_array, 'name');  // Getting only product names
$product_types_array = array_column($products_array, 'type'); // Getting only product types
$product_types = array_unique($product_types_array); // Removing duplicates

// Search

if (isset($_POST['search'])) {
    $search = htmlentities($_POST['search']);
    // Product Type Filter
    if (htmlentities($_POST['product-type'])) {
        $product_type = htmlentities($_POST['product-type']);
        $products_array = array_filter($products_array, function ($product) { // Filtering products array
            return $product['type'] == htmlentities($_POST['product-type']); // Return products with the same type
        });
    }
    // Keyword Filter

    $keyword = (htmlentities($_POST['keyword']));

    if ($keyword) {
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

    // Sort
    if (htmlentities($_POST['sort'])) {
        $sort = htmlentities($_POST['sort']);
        switch ($sort) {
            case "price-high":
                $sorting_message = "Price: high to low";
                usort($products_array, function ($a, $b) {
                    return $a['price'] < $b['price'];
                });
                break;
            case "price-low":
                $sorting_message = "Price: low to high";
                usort($products_array, function ($a, $b) {
                    return $a['price'] > $b['price'];
                });
                break;
            case "weight-high":
                $sorting_message = "Weight: high to low";
                usort($products_array, function ($a, $b) {
                    return $a['weight'] < $b['weight'];
                });
                break;
            case "weight-low":
                $sorting_message = "Weight: low to high";
                usort($products_array, function ($a, $b) {
                    return $a['weight'] > $b['weight'];
                });
                break;
        }
    }
}

?>