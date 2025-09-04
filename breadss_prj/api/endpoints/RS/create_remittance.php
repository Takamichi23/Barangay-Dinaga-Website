<?php
// File: api/endpoints/create_remittance.php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../../config/database.php';
include_once '../../models/RS/remittance.php';

$database = new Database();
$db = $database->connect();

// Set timezone
date_default_timezone_set('Asia/Manila');

$data = json_decode(file_get_contents("php://input"), true);

$remit_date_time = $data['remit_date_time'] ?? date('Y-m-d H:i:s');
$mode_of_payment = $data['mode_of_payment'] ?? '';
$resellable = (float)($data['resellable'] ?? 0);
$defective = (float)($data['defective'] ?? 0);
$assignment_id = $data['assignment_id'] ?? '';
$amount_to_remit = (float)($data['amount_to_remit'] ?? 0);
$status = 'Remitted'; // Explicitly set to Remitted

// Validate inputs
if (empty($assignment_id) || $resellable < 0 || $defective < 0 || $amount_to_remit < 0) {
    echo json_encode(['message' => 'Invalid input: Assignment ID required, and resellable/defective/amount must be non-negative.']);
    exit;
}

// Validate remit_date_time
if (!strtotime($remit_date_time)) {
    error_log("Invalid remit_date_time received: " . ($remit_date_time ?: 'NULL'));
    $remit_date_time = date('Y-m-d H:i:s');
}

// Check if a remittance already exists for this assignment
$query_check = "SELECT remittance_id FROM Remittance WHERE assignment_id = :assignment_id";
$stmt_check = $db->prepare($query_check);
$stmt_check->bindParam(':assignment_id', $assignment_id);
$stmt_check->execute();

if ($stmt_check->rowCount() > 0) {
    // Update existing remittance
    $query = "UPDATE Remittance SET
        remit_date_time = :remit_date_time,
        mode_of_payment = :mode_of_payment,
        resellable = :resellable,
        defective = :defective,
        amount_to_remit = :amount_to_remit,
        status = :status
        WHERE assignment_id = :assignment_id";
} else {
    // Insert new remittance
    $query = "INSERT INTO Remittance (
        remit_date_time, mode_of_payment, resellable, defective, assignment_id, amount_to_remit, status
    ) VALUES (
        :remit_date_time, :mode_of_payment, :resellable, :defective, :assignment_id, :amount_to_remit, :status
    )";
}

$stmt = $db->prepare($query);
$stmt->bindParam(':remit_date_time', $remit_date_time);
$stmt->bindParam(':mode_of_payment', $mode_of_payment);
$stmt->bindParam(':resellable', $resellable);
$stmt->bindParam(':defective', $defective);
$stmt->bindParam(':assignment_id', $assignment_id);
$stmt->bindParam(':amount_to_remit', $amount_to_remit);
$stmt->bindParam(':status', $status);

if ($stmt->execute()) {
    $remittance_id = $stmt_check->rowCount() > 0 ? $stmt_check->fetch(PDO::FETCH_ASSOC)['remittance_id'] : $db->lastInsertId();
    echo json_encode([
        'message' => 'Remittance recorded successfully.',
        'remittance_id' => (string)$remittance_id // Cast to string
    ]);
} else {
    echo json_encode(['message' => 'Failed to record remittance.']);
}
?>