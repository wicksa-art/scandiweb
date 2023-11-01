<?php
include_once 'Product.php';
include_once 'DVD.php';
include_once 'Book.php';
include_once 'Furniture.php';

class Database {
    private $conn;

    public function __construct() {
    $this->conn = new mysqli("6.tcp.eu.ngrok.io:11260", "root", "", "ProductDB");
    if ($this->conn->connect_error) {
        die("Connection failed: " . $this->conn->connect_error);
    }
}


public function saveProduct($product) {
    $sql = $this->conn->prepare("INSERT INTO Products (sku, name, price, type, size, weight, dimensions) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $type = get_class($product);
    $specificAttribute = $product->getSpecificAttribute();

    $dvdAttribute = $type === 'DVD' ? $specificAttribute : null;
    $bookAttribute = $type === 'Book' ? $specificAttribute : null;
    $furnitureAttribute = $type === 'Furniture' ? $specificAttribute : null;

    $sql->bind_param("ssdssss",
        $product->getSku(),
        $product->getName(),
        $product->getPrice(),
        $type,
        $dvdAttribute,
        $bookAttribute,
        $furnitureAttribute
    );

    $sql->execute();
    $sql->close();
}


public function deleteProducts($productSkus) {
    $skus = implode("','", array_map([$this->conn, 'real_escape_string'], $productSkus));
    $sql = "DELETE FROM Products WHERE sku IN ('$skus')";
    if ($this->conn->query($sql) === TRUE) {
        return true;
    } else {
        error_log("Error deleting products: " . $this->conn->error);  // Log the error
        return false;
    }
}



public function getProducts() {
    $result = $this->conn->query("SELECT * FROM Products ORDER BY id");
    $products = array();
    while($row = $result->fetch_assoc()) {
        $product = $this->createProductObject($row);
        if ($product !== null) {
            $products[] = $product;
        }
    }
    return $products;
}

private function createProductObject($row) {
    switch ($row['type']) {
        case 'DVD':
            return new DVD($row['sku'], $row['name'], $row['price'], $row['size']);
        case 'Book':
            return new Book($row['sku'], $row['name'], $row['price'], $row['weight']);
        case 'Furniture':
            return new Furniture($row['sku'], $row['name'], $row['price'], $row['dimensions']);
        default:
            return null;
    }
}

public function getProductBySKU($sku) {
    $sql = $this->conn->prepare("SELECT * FROM Products WHERE sku = ?");
    $sql->bind_param("s", $sku);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
    $sql->close();
    return $row ? $this->createProductObject($row) : null;
}

}
?>
