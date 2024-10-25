
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Product List</title>
</head>

<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Product List</h1>
            <div>
                <a href="add-product.php" class="btn btn-primary me-2">ADD</a>
                <button class="btn btn-danger" id="delete-product-btn" disabled>MASS DELETE</button>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row">
            <?php if (empty($products)): ?>
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        No products found.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input delete-checkbox"
                                        data-id="<?php echo $product['id']; ?>" id="checkbox-<?php echo $product['id']; ?>">
                                    <label class="form-check-label" for="checkbox-<?php echo $product['id']; ?>">Select</label>
                                </div>
                                <h5 class="card-title mt-3"><?php echo $product['sku']; ?></h5>
                                <p class="card-text"><?php echo $product['name']; ?></p>
                                <p class="card-text"><?php echo number_format($product['price'], 2); ?> $</p>
                                <p class="card-text">
                                    <?php
                                    if ($product['type'] == 'DVD' && isset($product['size_mb'])) {
                                        echo 'Size: ' . $product['size_mb'] . ' MB';
                                    } elseif ($product['type'] == 'Furniture' && isset($product['height_cm'], $product['width_cm'], $product['length_cm'])) {
                                        echo 'Dimensions: ' . $product['height_cm'] . ' x ' . $product['width_cm'] . ' x ' . $product['length_cm'] . ' cm';
                                    } elseif ($product['type'] == 'Book' && isset($product['weight_kg'])) {
                                        echo 'Weight: ' . $product['weight_kg'] . ' KG';
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </p>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>