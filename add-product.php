<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>

<form id="product_form" action="save-product.php" method="post">
    <label for="sku">SKU:</label>
    <input type="text" id="sku" name="sku" required><br>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="price">Price:</label>
    <input type="text" id="price" name="price" required><br>

    <label for="productType">Product Type:</label>
    <select id="productType" name="productType" onchange="toggleAttributes()">
        <option value="DVD">DVD</option>
        <option value="Book">Book</option>
        <option value="Furniture">Furniture</option>
    </select><br>

    <div id="dvdAttributes">
        <label for="size">Size (MB):</label>
        <input type="text" id="size" name="size">
    </div>

    <div id="bookAttributes" style="display:none;">
        <label for="weight">Weight (Kg):</label>
        <input type="text" id="weight" name="weight">
    </div>

    <div id="furnitureAttributes" style="display:none;">
        <label for="height">Height:</label>
        <input type="text" id="height" name="height"><br>
        <label for="width">Width:</label>
        <input type="text" id="width" name="width"><br>
        <label for="length">Length:</label>
        <input type="text" id="length" name="length">
    </div><br>

    <button type="submit">Save</button>
    <button type="button" onclick="window.location.href='index.php'">Cancel</button>
</form>

<script type="text/javascript">
    function toggleAttributes() {
        var productType = document.getElementById('productType').value;
        document.getElementById('dvdAttributes').style.display = (productType === 'DVD') ? 'block' : 'none';
        document.getElementById('bookAttributes').style.display = (productType === 'Book') ? 'block' : 'none';
        document.getElementById('furnitureAttributes').style.display = (productType === 'Furniture') ? 'block' : 'none';
    }
</script>

</body>
</html>
