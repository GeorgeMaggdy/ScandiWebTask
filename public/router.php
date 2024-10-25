<?php
// Parse the URL path
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/scandiwebtask/public', '', parse_url($requestUri, PHP_URL_PATH));

// Route definitions
if ($requestUri === '/productlist') {

    // Route for product list page
    include '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->showProductList();
} elseif ($requestUri === '/add_product') {
    // Route for add product page
    include '../app/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->add();


}
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $requestUri === '/add_product') {
    include 'controllers/ProductController.php';
    $productController = new ProductController();
    $productController->add();
}


else {
    // If no routes match, show 404 error
    include '../views/error404.php';
}
