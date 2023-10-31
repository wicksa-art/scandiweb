<?php
include_once 'Product.php';
include_once 'DVD.php';
include_once 'Book.php';
include_once 'Furniture.php';

class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "Maks2101!", "ProductDB");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function saveProduct($product) {
        $sql = $this->conn->prepare("INSERT INTO Products (sku, name, price, type, size, weight, dimensions) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $type = get_class($product);
        $specificAttribute = $product->getSpecificAttribute();
        $sql->bind_param("ssdsss",
            $product->getSku(),
            $product->getName(),
            $product->getPrice(),
            $type,
            $type === 'DVD' ? $specificAttribute : null,
            $type === 'Book' ? $specificAttribute : null,
            $type === 'Furniture' ? $specificAttribute : null
        );
        $sql->execute();
        $sql->close();
    }

    public function deleteProducts($productIds) {
        $ids = implode(',', array_map('intval', $productIds));
        $sql = "DELETE FROM Products WHERE id IN ($ids)";
        $this->conn->query($sql);
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
}
?>