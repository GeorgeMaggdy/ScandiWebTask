<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Add New Product</h1>

        <!-- Display Validation Errors -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="POST" id="product_form">

            <!-- SKU Field -->
            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter SKU" value="<?php echo htmlspecialchars($_POST['sku'] ?? ''); ?>" required>
            </div>

            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
            </div>

            <!-- Price Field -->
            <div class="mb-3">
                <label for="price" class="form-label">Price ($)</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" step="0.01" value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>" required>
            </div>

            <!-- Type Switcher Dropdown -->
            <div class="mb-3">
                <label for="productType" class="form-label">Type Switcher</label>
                <select class="form-select" id="productType" name="type" required>
                    <option value="" disabled selected>Select type</option>
                    <option value="DVD" <?php echo (($_POST['type'] ?? '') === 'DVD') ? 'selected' : ''; ?>>DVD</option>
                    <option value="Furniture" <?php echo (($_POST['type'] ?? '') === 'Furniture') ? 'selected' : ''; ?>>Furniture</option>
                    <option value="Book" <?php echo (($_POST['type'] ?? '') === 'Book') ? 'selected' : ''; ?>>Book</option>
                </select>
            </div>

            <!-- Dynamic Form Sections -->
            <div id="dynamic-form">
                <!-- DVD Section -->
                <div id="DVD" class="hidden">
                    <div class="mb-3">
                        <label for="size" class="form-label">Size (MB)</label>
                        <input type="number" class="form-control" id="size" name="size" placeholder="Enter size in MB" value="<?php echo htmlspecialchars($_POST['size'] ?? ''); ?>">
                    </div>
                    <p>Product description: Please enter the size in MB for DVDs.</p>
                </div>
                
                <!-- Furniture Section -->
                <div id="Furniture" class="hidden">
                    <div class="mb-3">
                        <label for="height" class="form-label">Height (CM)</label>
                        <input type="number" class="form-control" id="height" name="height" placeholder="Enter height" value="<?php echo htmlspecialchars($_POST['height'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="width" class="form-label">Width (CM)</label>
                        <input type="number" class="form-control" id="width" name="width" placeholder="Enter width" value="<?php echo htmlspecialchars($_POST['width'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="length" class="form-label">Length (CM)</label>
                        <input type="number" class="form-control" id="length" name="length" placeholder="Enter length" value="<?php echo htmlspecialchars($_POST['length'] ?? ''); ?>">
                    </div>
                    <p>Product description: Please provide dimensions in HxWxL format for furniture.</p>
                </div>
                
                <!-- Book Section -->
                <div id="Book" class="hidden">
                    <div class="mb-3">
                        <label for="weight" class="form-label">Weight (KG)</label>
                        <input type="number" class="form-control" id="weight" name="weight" placeholder="Enter weight in KG" value="<?php echo htmlspecialchars($_POST['weight'] ?? ''); ?>">
                    </div>
                    <p>Product description: Enter the weight of the book.</p>
                </div>
            </div>

            <!-- Save/Cancel Buttons -->
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.reload()">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Change form dynamically based on product type selected
            $('#productType').on('change', function() {
                // Hide all sections first
                $('#dynamic-form > div').addClass('hidden');
                
                // Show the selected product type's form
                const selectedType = $(this).val();
                $('#' + selectedType).removeClass('hidden');
            });
        });
    </script>
</body>
</html>
