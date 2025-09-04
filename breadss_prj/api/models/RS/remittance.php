<?php   
class Remittance {
    private $conn;
    private $table = "remittance";

    // Remittance properties
    public $remittance_id;
    public $remit_date_time;
    public $mode_of_payment;
    public $resellable;
    public $defective;
    public $assignment_id;

    public function __construct($db){
        $this->conn = $db;
    }

    // Read all remittance records
    public function read() {
        $query = "
            SELECT 
                r.remittance_id,
                r.remit_date_time,
                r.resellable,
                r.defective,
                r.mode_of_payment,
                rs.f_name,
                rs.m_name,
                rs.l_name,
                rs.phone_number,
                a.carried_product
            FROM remittance r
            LEFT JOIN assignment a ON r.assignment_id = a.assignment_id
            LEFT JOIN reseller rs ON a.reseller_id = rs.reseller_id
            ORDER BY r.remit_date_time DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create a new remittance
    public function create() {
        $query = "INSERT INTO " . $this->table . "
            SET 
                remit_date_time = :remit_date_time,
                resellable = :resellable,
                defective = :defective,
                mode_of_payment = :mode_of_payment,
                assignment_id = :assignment_id";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->remit_date_time = htmlspecialchars(strip_tags($this->remit_date_time));
        $this->resellable = htmlspecialchars(strip_tags($this->resellable));
        $this->defective = htmlspecialchars(strip_tags($this->defective));
        $this->mode_of_payment = htmlspecialchars(strip_tags($this->mode_of_payment));
        $this->assignment_id = htmlspecialchars(strip_tags($this->assignment_id));

        // Bind parameters
        $stmt->bindParam(':remit_date_time', $this->remit_date_time);
        $stmt->bindParam(':resellable', $this->resellable);
        $stmt->bindParam(':defective', $this->defective);
        $stmt->bindParam(':mode_of_payment', $this->mode_of_payment);
        $stmt->bindParam(':assignment_id', $this->assignment_id);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }

    // Update a remittance
    public function update() {
        $query = "UPDATE " . $this->table . "
            SET 
                remit_date_time = :remit_date_time,
                resellable = :resellable,
                defective = :defective,
                mode_of_payment = :mode_of_payment,
                assignment_id = :assignment_id
            WHERE remittance_id = :remittance_id";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->remittance_id = htmlspecialchars(strip_tags($this->remittance_id));
        $this->remit_date_time = htmlspecialchars(strip_tags($this->remit_date_time));
        $this->resellable = htmlspecialchars(strip_tags($this->resellable));
        $this->defective = htmlspecialchars(strip_tags($this->defective));
        $this->mode_of_payment = htmlspecialchars(strip_tags($this->mode_of_payment));
        $this->assignment_id = htmlspecialchars(strip_tags($this->assignment_id));

        // Bind parameters
        $stmt->bindParam(':remittance_id', $this->remittance_id);
        $stmt->bindParam(':remit_date_time', $this->remit_date_time);
        $stmt->bindParam(':resellable', $this->resellable);
        $stmt->bindParam(':defective', $this->defective);
        $stmt->bindParam(':mode_of_payment', $this->mode_of_payment);
        $stmt->bindParam(':assignment_id', $this->assignment_id);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }

    // Delete a remittance
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE remittance_id = :remittance_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':remittance_id', $this->remittance_id);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }
}
?>
