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
                header("Location: products_list");
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
//     public function delete_products()
//     {

// echo "1";
//         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//             $data = json_decode(file_get_contents('php://input'), true);
//             $ids = implode(',', array_map('intval', $data['ids']));

//             $db = new Database();
//             $connection = $db->getConnection();
//             $connection->query("DELETE FROM products WHERE id IN ($ids)");
//         }

//     }
// }

public function delete_products()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Ensure 'ids' is provided and is an array
        if (isset($data['ids']) && is_array($data['ids'])) {
            $ids = implode(',', array_map('intval', $data['ids']));

            $db = new Database();
            $connection = $db->getConnection();

            // Execute the delete query
            if ($connection->query("DELETE FROM products WHERE id IN ($ids)")) {
                // Return JSON response on success
                echo json_encode(['status' => 'success', 'message' => 'Products deleted successfully']);
            } else {
                // Return JSON response on failure
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete products']);
            }
        } else {
            // Return JSON response if 'ids' is not provided or not an array
            echo json_encode(['status' => 'error', 'message' => 'Invalid product IDs']);
        }
    } else {
        // Return JSON response if the request method is not POST
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
    exit(); // Stop further script execution
}
}
