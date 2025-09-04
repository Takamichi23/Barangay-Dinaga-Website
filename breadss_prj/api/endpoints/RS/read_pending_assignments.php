<?php
// File: api/endpoints/read_pending_assignments.php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/RS/assignment.php';
include_once '../../models/RS/reseller.php';

$database = new Database();
$db = $database->connect();

// Set timezone
date_default_timezone_set('Asia/Manila');
$db->query("SET time_zone = '+08:00'");

// Query assignments without a remittance or with status 'Pending'
$query = "
    SELECT a.assignment_id, 
           CONCAT(rs.f_name, ' ', rs.m_name, ' ', rs.l_name) AS reseller_name,
           a.date_time,
           a.carried_product,
           a.amount_to_remit
    FROM Assignment a
    JOIN Reseller rs ON a.reseller_id = rs.reseller_id
    LEFT JOIN Remittance r ON a.assignment_id = r.assignment_id
    WHERE r.remittance_id IS NULL OR r.status = 'Pending'
    ORDER BY a.date_time DESC
";

$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();

if ($num > 0) {
    $assignments_arr = ['data' => []];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $assignment_item = [
            'assignment_id' => (string)$row['assignment_id'], // Cast to string
            'reseller_name' => $row['reseller_name'],
            'date_time' => $row['date_time'],
            'carried_product' => (float)$row['carried_product'],
            'amount_to_remit' => (float)$row['amount_to_remit']
        ];

        array_push($assignments_arr['data'], $assignment_item);
    }

    echo json_encode($assignments_arr);
} else {
    echo json_encode(['message' => 'No pending assignments found.', 'data' => []]);
}
?>