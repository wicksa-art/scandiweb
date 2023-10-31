<?php
include_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['skus'])) {
    $skus = json_decode($_POST['skus']);
    $db = new Database();
    $db->deleteProducts($skus);
}
?>
