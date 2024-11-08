<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Product List</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Product List</h1>
            <div>
                <a href="add_product" class="btn btn-primary me-2">ADD</a>
                <button class="btn btn-danger" id="delete-product-btn">MASS DELETE</button>
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
                                        data-id="<?php echo $product['sku']; ?>" id="<?php echo $product['sku']; ?>">
                                    <label class="form-check-label" for="<?php echo $product['sku']; ?>">Select</label>
                                </div>
                                <h5 class="card-title mt-3"><?php echo htmlspecialchars($product['sku']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['name']); ?></p>
                                <p class="card-text"><?php echo number_format($product['price'], 2); ?> $</p>
                                <p class="card-text">
                                    <?php
                                    if (isset($product['size'])) {
                                        echo 'Size: ' . htmlspecialchars($product['size']) . ' MB';
                                    } elseif (isset($product['weight'])) {
                                        echo 'Weight: ' . htmlspecialchars($product['weight']) . ' KG';
                                    } else {
                                        echo 'Dimensions: ' . htmlspecialchars($product['height']) . ' x ' . htmlspecialchars($product['width']) . ' x ' . htmlspecialchars($product['length']) . ' cm';
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

    <script>
   $(document).ready(function () {
    $('#delete-product-btn').on('click', function () {
        let selectedIds = [];
        let type = '';

        $('.delete-checkbox:checked').each(function () {
            selectedIds.push($(this).data('id'));
            type = $(this).data('type');
        });

        console.log('Selected IDs:', selectedIds);  // Debugging
        console.log('Product Type:', type);  // Debugging

        if (selectedIds.length > 0 && type) {
            fetch('/scandiwebtask/public/delete_products', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ type: type, ids: selectedIds })
            }).then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.reload(); // Refresh page after delete
                    } else {
                        alert(data.message); // Display error message
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert('No products selected or product type not specified');
        }
    });
});


    </script>
</body>

</html>