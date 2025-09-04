<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->reseller_id) &&
    !empty($data->carried_product) &&
    !empty($data->amount_to_remit) &&
    !empty($data->date_time)
) {
    $database = new Database();
    $db = $database->connect();

    // Validate reseller_id
    $query_check = "SELECT reseller_id FROM Reseller WHERE reseller_id = :reseller_id";
    $stmt_check = $db->prepare($query_check);
    $stmt_check->bindParam(':reseller_id', $data->reseller_id);
    $stmt_check->execute();

    if ($stmt_check->rowCount() == 0) {
        http_response_code(400);
        echo json_encode(["message" => "Invalid reseller_id: Reseller does not exist."]);
        exit();
    }

    // Validate date_time
    if (!strtotime($data->date_time)) {
        http_response_code(400);
        echo json_encode(["message" => "Invalid date_time format."]);
        exit();
    }

    // Validate carried_product and amount_to_remit
    if ($data->carried_product <= 0 || $data->amount_to_remit < 0) {
        http_response_code(400);
        echo json_encode(["message" => "Carried product must be positive, and amount to remit must be non-negative."]);
        exit();
    }

    $query = "INSERT INTO Assignment (reseller_id, carried_product, amount_to_remit, date_time, status)
              VALUES (:reseller_id, :carried_product, :amount_to_remit, :date_time, 'Pending')";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':reseller_id', $data->reseller_id);
    $stmt->bindParam(':carried_product', $data->carried_product);
    $stmt->bindParam(':amount_to_remit', $data->amount_to_remit);
    $stmt->bindParam(':date_time', $data->date_time);

    try {
        if ($stmt->execute()) {
            $assignment_id = $db->lastInsertId();
            http_response_code(201);
            echo json_encode([
                "message" => "Assignment created successfully.",
                "assignment_id" => (string)$assignment_id
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Failed to create assignment due to database error."]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Database error: " . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Incomplete data: reseller_id, carried_product, amount_to_remit, and date_time are required."]);
}
?>