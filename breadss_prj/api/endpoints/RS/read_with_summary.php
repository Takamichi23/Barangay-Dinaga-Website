<?php
// File: api/remittance/read_with_summary.php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/RS/remittance.php';
include_once '../../models/RS/assignment.php';
include_once '../../models/RS/reseller.php';

$database = new Database();
$db = $database->connect();

// Set timezone
date_default_timezone_set('Asia/Manila');
$db->query("SET time_zone = '+08:00'");

$remittanceId = isset($_GET['remittance_id']) ? $_GET['remittance_id'] : null;

// Dynamic query based on remittance_id
$query = "
    SELECT r.remittance_id, 
           COALESCE(r.remit_date_time, '1970-01-01 00:00:00') AS remit_date_time, 
           CONCAT(rs.f_name, ' ', rs.m_name, ' ', rs.l_name) AS reseller_name, 
           r.mode_of_payment, r.resellable, r.defective, 
           a.carried_product, a.amount_to_remit, 
           COALESCE(r.status, 'Remitted') AS status,
           (a.carried_product - r.defective) AS net,
           (a.carried_product - r.defective - r.resellable) AS total_sold,
           ((a.carried_product - r.defective - r.resellable) * 0.20) AS reseller_commission,
           ((a.carried_product - r.defective - r.resellable) * 0.80) AS bakery_income
    FROM Remittance r
    JOIN Assignment a ON r.assignment_id = a.assignment_id
    JOIN Reseller rs ON a.reseller_id = rs.reseller_id      
";

$params = [];
if ($remittanceId) {
    $query .= " WHERE r.remittance_id = :remittance_id";
    $params[':remittance_id'] = $remittanceId;
}

$stmt = $db->prepare($query);
$stmt->execute($params);

$num = $stmt->rowCount();

if ($num > 0) {
    $remittance_arr = ['data' => []];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $carried = (float)($row['carried_product'] ?? 0);
        $defective = (float)($row['defective'] ?? 0);
        $resellable = (float)($row['resellable'] ?? 0);

        $net = $carried - $defective;
        $total_sold = $net - $resellable;
        $reseller_commission = $total_sold * 0.20;
        $bakery_income = $total_sold - $reseller_commission;

        // Validate remit_date_time
        $remit_date_time = $row['remit_date_time'];
        if (empty($remit_date_time) || !strtotime($remit_date_time)) {
            error_log("Invalid remit_date_time for remittance_id {$row['remittance_id']}: " . ($remit_date_time ?: 'NULL'));
            $remit_date_time = '1970-01-01 00:00:00';
        }

        $remittance_item = [
            'remittance_id' => (string)$row['remittance_id'], // Cast to string
            'remit_date_time' => $remit_date_time,
            'reseller_name' => $row['reseller_name'],
            'amount_to_remit' => (float)$row['amount_to_remit'],
            'carried_product' => $carried,
            'resellable' => $resellable,
            'defective' => $defective,
            'mode_of_payment' => $row['mode_of_payment'],
            'status' => $row['status'],
            'summary' => [
                'net' => $net,
                'total_sold' => $total_sold,
                'reseller_commission' => $reseller_commission,
                'bakery_income' => $bakery_income
            ]
        ];

        array_push($remittance_arr['data'], $remittance_item);
    }

    echo json_encode($remittance_arr);
} else {
    echo json_encode(['message' => 'No remittance records found.', 'data' => []]);
}
?>