<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/RS/remittance.php';
include_once '../../models/RS/assignment.php';
include_once '../../models/RS/reseller.php';

$database = new Database();
$db = $database->connect();

date_default_timezone_set('Asia/Manila');
$db->query("SET time_zone = '+08:00'");

$query = "
    SELECT r.remittance_id,
           CONCAT(rs.f_name, ' ', rs.m_name, ' ', rs.l_name) AS reseller_name,
           r.remit_date_time,
           a.carried_product,
           r.amount_to_remit,
           r.mode_of_payment,
           r.status
    FROM Remittance r
    JOIN Assignment a ON r.assignment_id = a.assignment_id
    JOIN Reseller rs ON a.reseller_id = rs.reseller_id
    ORDER BY r.remit_date_time DESC
";

$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();

if ($num > 0) {
    $remittances_arr = ['data' => []];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $remittance_item = [
            'remittance_id' => (string)$row['remittance_id'],
            'reseller_name' => $row['reseller_name'],
            'remit_date_time' => $row['remit_date_time'],
            'carried_product' => (float)$row['carried_product'],
            'amount_to_remit' => (float)$row['amount_to_remit'],
            'mode_of_payment' => $row['mode_of_payment'],
            'status' => $row['status']
        ];
        array_push($remittances_arr['data'], $remittance_item);
    }
    echo json_encode($remittances_arr);
} else {
    echo json_encode(['message' => 'No remittances found.', 'data' => []]);
}
?>