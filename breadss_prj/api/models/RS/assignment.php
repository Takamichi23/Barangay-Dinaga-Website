<?php
class Assignment {
    private $conn;
    private $table = "assignment";

    // Properties
    public $assignment_id;
    public $date_time;
    public $carried_product;
    public $amount_to_remit;
    public $reseller_id;

    // Constructor
    public function __construct($db) {
        $this->conn = $db; 
    }

    // Read all assignments
    public function read() {
    $query = 'SELECT 
                a.assignment_id,
                CONCAT(r.f_name, " ", r.m_name, " ", r.l_name) AS reseller_name,
                a.date_time,
                a.carried_product,
                a.amount_to_remit,
                a.status
              FROM assignment a
              JOIN reseller r ON a.reseller_id = r.reseller_id
              ORDER BY a.date_time DESC';

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
}


    // Read single assignment
    public function read_single() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE assignment_id = :assignment_id LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':assignment_id', $this->assignment_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->assignment_id = $row['assignment_id'];
            $this->date_time = $row['date_time'];
            $this->carried_product = $row['carried_product'];
            $this->amount_to_remit = $row['amount_to_remit'];
            $this->reseller_id = $row['reseller_id'];
        }
    }

    // Create assignment
    public function create() {
    $query = "INSERT INTO assignment 
              SET reseller_id = :reseller_id, 
                  date_time = NOW(), 
                  carried_product = :carried_product, 
                  amount_to_remit = :amount_to_remit,
                  status = 'Pending'";

    $stmt = $this->conn->prepare($query);

    // Calculate amount_to_remit correctly: 80% of carried product
    $this->amount_to_remit = $this->carried_product * 0.80;

    // Sanitize
    $this->reseller_id = htmlspecialchars(strip_tags($this->reseller_id));
    $this->carried_product = htmlspecialchars(strip_tags($this->carried_product));

    // Bind
    $stmt->bindParam(':reseller_id', $this->reseller_id);
    $stmt->bindParam(':carried_product', $this->carried_product);
    $stmt->bindParam(':amount_to_remit', $this->amount_to_remit);

    return $stmt->execute();
}
    public function updateStatus($newStatus) {
    $query = "UPDATE assignment SET status = :status WHERE assignment_id = :assignment_id";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':status', $newStatus);
    $stmt->bindParam(':assignment_id', $this->assignment_id);

    return $stmt->execute();
}

    // Update assignment
    public function update() {
        $query = 'UPDATE ' . $this->table . '
            SET 
                date_time = :date_time,
                carried_product = :carried_product,
                amount_to_remit = :amount_to_remit,
                reseller_id = :reseller_id
            WHERE assignment_id = :assignment_id';

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->assignment_id = htmlspecialchars(strip_tags($this->assignment_id));
        $this->date_time = htmlspecialchars(strip_tags($this->date_time));
        $this->carried_product = htmlspecialchars(strip_tags($this->carried_product));
        $this->amount_to_remit = htmlspecialchars(strip_tags($this->amount_to_remit));
        $this->reseller_id = htmlspecialchars(strip_tags($this->reseller_id));

        // Bind params
        $stmt->bindParam(':assignment_id', $this->assignment_id);
        $stmt->bindParam(':date_time', $this->date_time);
        $stmt->bindParam(':carried_product', $this->carried_product);
        $stmt->bindParam(':amount_to_remit', $this->amount_to_remit);
        $stmt->bindParam(':reseller_id', $this->reseller_id);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }

    // Delete assignment
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE assignment_id = :assignment_id';
        $stmt = $this->conn->prepare($query);

        // Clean and bind
        $this->assignment_id = htmlspecialchars(strip_tags($this->assignment_id));
        $stmt->bindParam(':assignment_id', $this->assignment_id);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }
}
?>
