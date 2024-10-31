<?php
// Parse the URL path
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/scandiwebtask/public', '', parse_url($requestUri, PHP_URL_PATH));

// Debugging: output the parsed request URI
  // Stop execution to inspect the output

// Route definitions
if ($requestUri === '/products_list') {
    include '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->showProductList();
} elseif ($requestUri === '/add_product') {
    include '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->add();
} elseif ($requestUri === '/delete_product') {
    include '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->delete_products(); }
else {
    echo "no view";
}
