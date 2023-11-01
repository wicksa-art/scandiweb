<?php
include_once 'Database.php';
include_once 'Product.php';
include_once 'DVD.php';
include_once 'Book.php';
include_once 'Furniture.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $productType = $_POST['productType'];

    $db = new Database();

    try {
        switch ($productType) {
            case 'DVD':
                $size = $_POST['size'];
                $product = new DVD($sku, $name, $price, $size);
                break;
            case 'Book':
                $weight = $_POST['weight'];
                $product = new Book($sku, $name, $price, $weight);
                break;
            case 'Furniture':
                $dimensions = $_POST['height'] . 'x' . $_POST['width'] . 'x' . $_POST['length'];
                $product = new Furniture($sku, $name, $price, $dimensions);
                break;
        }

        $db->saveProduct($product);
        header('Location: index.php');

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
