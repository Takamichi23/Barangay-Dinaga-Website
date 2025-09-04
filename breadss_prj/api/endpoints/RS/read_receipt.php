<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/RS/remittance.php';

$database = new Database();
$db = $database->connect();

// Read JSON input
$data = json_decode(file_get_contents("php://input"));

// Validate remittance_id
if (!isset($data->remittance_id)) {
    echo json_encode(['message' => 'Missing remittance_id']);
    exit;
}

$remittance_id = $data->remittance_id;

$query = "
SELECT 
    r.remit_date_time,
    CONCAT(rslr.f_name, ' ', rslr.m_name, ' ', rslr.l_name) AS reseller_name,
    a.amount_to_remit,
    a.carried_product,
    r.resellable,
    r.defective,
    r.mode_of_payment
FROM remittance r
JOIN assignment a ON r.assignment_id = a.assignment_id
JOIN reseller rslr ON a.reseller_id = rslr.reseller_id
WHERE r.remittance_id = :remittance_id
";

$stmt = $db->prepare($query);
$stmt->bindParam(':remittance_id', $remittance_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
} else {
    echo json_encode(['message' => 'Remittance not found']);
}
?>
