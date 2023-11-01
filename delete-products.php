<?php
include_once 'Database.php';

$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['skus'])) {
    $skus = json_decode($_POST['skus'], true);
    if (is_array($skus) && !empty($skus)) {
        $db = new Database();
        $deletionResult = $db->deleteProducts($skus);
        if ($deletionResult) {
            $response['success'] = true;
            $response['message'] = 'Products deleted successfully.';
        } else {
            $response['message'] = 'Failed to delete products.';
        }
    } else {
        $response['message'] = 'Invalid or empty SKUs data.';
    }
} else {
    $response['message'] = 'Invalid request method or missing skus data.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
