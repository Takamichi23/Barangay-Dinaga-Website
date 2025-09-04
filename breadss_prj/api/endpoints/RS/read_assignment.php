<?php  
// api/endpoints/read_assignment.php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/RS/assignment.php'; 
include_once '../../models/RS/reseller.php'; 

$database = new Database();
$db = $database->connect();

$assignment = new Assignment($db);

$result = $assignment->read();
$num = $result->rowCount();

if ($num > 0) {
    $assignments_arr = array();
    $assignments_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $assignment_item = array(
            'assignment_id'     => $assignment_id,
            'reseller_name'     => $reseller_name,  
            'date_time'         => $date_time,
            'carried_product'   => $carried_product,
            'amount_to_remit'   => $amount_to_remit,
            'status'            => $status         
        );

        array_push($assignments_arr['data'], $assignment_item);
    }

    echo json_encode($assignments_arr);
} else {
    echo json_encode(['message' => 'No assignments found.']);
}
