<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/RS/reseller.php';

// Instantiate database
$database = new Database();
$db = $database->connect();

// Instantiate reseller class
$reseller = new Reseller($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Validate required fields
if (
    !empty($data->f_name) &&
    !empty($data->l_name) &&
    !empty($data->phone_number) &&
    !empty($data->address)
) {
    // Set reseller properties
    $reseller->f_name = $data->f_name;
    $reseller->m_name = $data->m_name ?? '';
    $reseller->l_name = $data->l_name;
    $reseller->phone_number = $data->phone_number;
    $reseller->address = $data->address;

    // Add reseller
    if ($reseller->create()) {
        echo json_encode([
            'success' => true,
            'message' => 'Reseller added successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add reseller.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Incomplete data. Required fields: f_name, l_name, phone_number, address.'
    ]);
}
?>