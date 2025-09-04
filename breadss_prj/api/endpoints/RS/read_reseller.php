<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Content-Type: application/json');


include_once '../../config/database.php';
include_once '../../models/RS/reseller.php';

// Instantiate database
$database = new Database();
$db = $database->connect();

// Instantiate reseller class
$reseller = new Reseller($db);

// Reseller query
$result = $reseller->read();

// Get row count
$num = $result->rowCount();

// Check if there are resellers
if ($num > 0) {
    $resellers_arr = array();
    $resellers_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $reseller_item = array(
            'reseller_id' => $reseller_id,
            'f_name' => $f_name,
            'm_name' => $m_name,
            'l_name' => $l_name,
            'phone_number' => $phone_number,
            'address' => $address
        );


        array_push($resellers_arr['data'], $reseller_item);
    }

    echo json_encode($resellers_arr);
} else {
    echo json_encode(
        array('message' => 'No resellers found.')
    );
}
?>