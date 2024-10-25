<?php

require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/DVD.php';
require_once __DIR__ . '/../models/Furniture.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../validators/ProductValidator.php';




class ProductController
{
    private $productClasses = [
        'DVD' => 'DVD',
        'Book' => 'Book',
        'Furniture' => 'Furniture'
    ];

    // Display Product List
    public function showProductList()
    {
        $db = new Database();
        $conn = $db->getConnection();

        // Fetch all products from the database
        $result = $conn->query("SELECT * FROM products");
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

        require_once __DIR__ . '/../views/products/products_list.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productValidator = new ProductValidator();
            $errors = $productValidator->validate($_POST);

            if (empty($errors)) {
                // Save product logic
                $this->saveProduct();
                
                // Redirect or set a success message
                $_SESSION['success'] = "Product added successfully!";
                header("Location: products_list.php");
                exit();
            } else {
                $_SESSION['errors'] = $errors; // Store errors in session
            }
        
        }
        require_once __DIR__ . '/../views/products/add_product.php'; // Load the add product view
    }


    // Save Product
    public function saveProduct()
    {
        $sku = $_POST['sku'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $productType = $_POST['type'];

        // Ensure a valid product type is provided
        if (!isset($this->productClasses[$productType])) {
            die("Invalid product type");
        }

        $productClass = $this->productClasses[$productType];

        // Dynamically instantiate the product class based on the product type
        $product = new $productClass(
            $sku,
            $name,
            $price,
            $_POST // Pass all POST data to handle attributes
        );
        var_dump($product);
        exit();
        // Save the product to the database
        $this->saveToDatabase($product);
    }

    // Save to Database using prepared statements
    private function saveToDatabase($product)
    {
        $db = new Database();
        $connection = $db->getConnection();

        // Insert query provided by the product model class
        $stmt = $connection->prepare($product->getInsertQuery());

        // Bind parameters dynamically using the product's bind method
        $product->bindParams($stmt);

        $stmt->execute();
        $stmt->close();
    }
}
