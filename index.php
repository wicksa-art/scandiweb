<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<button type="button" onclick="window.location.href='add-product.php'">ADD</button>
<button type="button" onclick="massDelete()">MASS DELETE</button>

<table>
    <thead>
        <tr>
            <th></th>  <!-- For delete checkboxes -->
            <th>SKU</th>
            <th>Name</th>
            <th>Price ($)</th>
            <th>Specific Attribute</th>
        </tr>
    </thead>
    <tbody>
        <!-- Populate rows with PHP -->
        <?php
        include_once 'Database.php';
        $db = new Database();
        $products = $db->getProducts();
        foreach ($products as $product): ?>
        <tr>
            <td><input type="checkbox" class="delete-checkbox" value="<?php echo $product->getSku(); ?>"></td>
            <td><?php echo $product->getSku(); ?></td>
            <td><?php echo $product->getName(); ?></td>
            <td><?php echo $product->getPrice(); ?></td>
            <td>
                <?php echo $product->getSpecificAttribute(); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
function massDelete() {
    var selectedSkus = [];
    document.querySelectorAll('.delete-checkbox:checked').forEach(function(checkbox) {
        selectedSkus.push(checkbox.value);
    });
    if (selectedSkus.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete-products.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.querySelectorAll('.delete-checkbox:checked').forEach(function(checkbox) {
                            checkbox.closest('tr').remove();
                        });
                        console.log("Products deleted successfully:", response.message);
                    } else {
                        console.error("Error deleting products:", response.message);
                    }
                } else {
                    console.error("Error deleting products:", xhr.status, xhr.statusText, xhr.responseText);
                }
            }
        };
        xhr.send("skus=" + JSON.stringify(selectedSkus));
    }
}


</script>

</body>
</html>
