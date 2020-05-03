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