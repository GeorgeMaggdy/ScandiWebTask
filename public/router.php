<?php

use App\Controllers\ProductController;

require_once __DIR__ . '/../vendor/autoload.php';

// Parse the URL path
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/scandiwebtask/public', '', parse_url($requestUri, PHP_URL_PATH));

$controller = new ProductController();

// Route definitions
if ($requestUri === '/products_list') {
    $controller->showProductList();
} elseif ($requestUri === '/add_product') {
    $controller->addProduct();
} elseif ($requestUri === '/delete_products') {
    $controller->deleteProducts();
} else {
    http_response_code(404);
    echo "Page not found";
}
